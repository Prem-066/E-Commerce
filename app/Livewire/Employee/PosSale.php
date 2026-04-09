<?php

namespace App\Livewire\Employee;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Product;
use App\Models\Employee;
use App\Models\Order;
use App\Models\OrderItem;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Mail\OrderSuccessMail;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendOrderEmailJob;
use App\Models\Manager;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Str;

class PosSale extends Component
{
    public $selectedOrder = null;
    public $cart = [];
    public $total = 0;
    public $customer_phone;
    public $payment_method = 'cash';
    public $customer_name;
    public $customer_email;


    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if ($product && $product->stock > 0) {
            if (isset($this->cart[$productId])) {
                $this->cart[$productId]['qty']++;
            } else {
                $this->cart[$productId] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'qty' => 1
                ];
            }
            $this->calculateTotal();
        }
    }


    public function completeSale()
    {
        $this->validate([
            'customer_phone' => 'required|digits:10',
            'customer_name' => 'required|min:3',
            'customer_email' => 'required|email',
        ]);
        if (empty($this->cart)) return;

        if ($this->payment_method === 'online') {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $line_items = [];
            foreach ($this->cart as $item) {
                $line_items[] = [
                    'price_data' => [
                        'currency' => 'inr',
                        'product_data' => ['name' => $item['name']],
                        'unit_amount' => $item['price'] * 100,
                    ],
                    'quantity' => $item['qty'],
                ];
            }

            $session = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => $this->customer_email,
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => route('pos.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',

                'metadata' => [
                    'customer_name' => $this->customer_name ?: 'Walk-in Customer',
                    'customer_phone' => $this->customer_phone,
                    'customer_email' => $this->customer_email,
                    'cart_data' => json_encode($this->cart),
                    'user_id' => auth()->id()
                ]
            ]);

            return redirect()->away($session->url);
        }

        $this->processOrder();
    }
    public function processOrder($payment_id = null)
    {
        $user = auth()->user();
        $storeId = null;
        $adminId = null;

        if ($user->hasRole('Store Manager')) {
            $manager = Manager::where('user_id', $user->id)->first();
            if ($manager) {
                $storeId = $manager->store_id;
                $adminId = $manager->admin_id ?? $user->id;
            }
        } elseif ($user->hasRole('Employee POS')) {
            $employee = Employee::where('user_id', $user->id)->first();
            if ($employee) {
                $storeId = $employee->store_id;
                $adminId = $employee->admin_id;
            }
        }

        if (!$storeId) {
            sweetalert('Store information not found!', 'error');
            return;
        }
        $order = Order::create([
            'admin_id'      => $adminId,
            'store_id'      => $storeId,
            'employee_id'   => $user->id,
            'total_amount'  => $this->total,
            'order_number'  => 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(8)),
            'order_type'    => 'offline',
            'order_status'        => 'Delivered',
            'payment_status'        => 'paid',
            'payment_method' => $this->payment_method,
            'user_id' => $user->id,
            'payment_id'    => $payment_id,
            'customer_name' => $this->customer_name ?: 'Walk-in Customer',
            'customer_phone' => $this->customer_phone,
            'customer_email' => $this->customer_email,
        ]);

        foreach ($this->cart as $id => $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $id,
                'qty'        => $item['qty'],
                'price'      => $item['price'],
                'status'      => 'Delivered',
            ]);

            Product::find($id)->decrement('stock', $item['qty']);
        }

        if ($this->customer_email) {
            $emailCart = $this->cart;

            DB::afterCommit(function () use ($order, $emailCart) {
                SendOrderEmailJob::dispatch(
                    $order->id,
                    $emailCart,
                    $this->customer_email
                );
            });
        }
        $this->reset(['cart', 'total', 'customer_name', 'customer_phone', 'customer_email']);
        sweetalert('Sale Completed Successfully!', 'success');
    }

    public function calculateTotal()
    {
        $this->total = array_reduce($this->cart, function ($i, $obj) {
            return $i + ($obj['price'] * $obj['qty']);
        }, 0);
    }
    public $search = '';

    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
        $this->calculateTotal();
    }

    public function decreaseQty($id)
    {
        if (isset($this->cart[$id])) {
            if ($this->cart[$id]['qty'] > 1) {
                $this->cart[$id]['qty']--;
            } else {
                unset($this->cart[$id]);
            }
            $this->calculateTotal();
        }
    }

    #[On('open-order-modal')]
    public function loadOrderForModal($orderId)
    {
        $this->selectedOrder = Order::with('items.product')->find($orderId);

        $this->dispatch('openModal');
    }

    public function viewOrderDetails($orderId)
    {
        $this->selectedOrder = Order::with('items.product')->find($orderId);
        $this->dispatch('openModal');
    }

    #[Layout('layouts.admin')]
    #[Title('Inventory')]
    public function render()
    {
        $user = auth()->user();
        $storeId = null;

        if ($user->hasRole('Store Manager')) {
            $manager = Manager::where('user_id', $user->id)->first();
            $storeId = $manager ? $manager->store_id : null;
        } elseif ($user->hasRole('Employee POS')) {
            $employee = Employee::where('user_id', $user->id)->first();
            $storeId = $employee ? $employee->store_id : null;
        }

        $productsQuery = Product::where('stock', '>', 0);

        if ($storeId) {
            $productsQuery->where('store_id', $storeId);

            $recentOrders = Order::where('store_id', $storeId)->where('order_type', 'offline')
                ->get();
        } else {
            $recentOrders = collect();
        }

        if ($this->search) {
            $productsQuery->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('sku', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhereHas('category', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('subcategory', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        $products = $productsQuery->get();

        return view('livewire.employee.pos-sale', compact('products', 'recentOrders'));
    }
}
