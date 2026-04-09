<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Store;
use App\Models\Order;
use App\Models\User;
use App\Models\Employee;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    #[Layout('layouts.admin')]
    #[Title('Super Admin')]
    public $filterRange = 'monthly';
    public $selectedStoreId = null;
    public $selectedOrder = null;

    public function selectStore($id)
    {
        $this->selectedStoreId = ($this->selectedStoreId == $id) ? null : $id;
    }

    public function viewOrder($id)
{
    $this->selectedOrder = Order::find($id);

    // Full item data (like history page)
    $this->selectedOrder->items = DB::table('order_items')
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->where('order_items.order_id', $id)
        ->select(
            'order_items.*',
            'products.name',
            'products.image',
            'products.sku',
            'products.return_policy_days',
            'products.delivery_charge'
        )
        ->get();

    // Redeemed points
    $this->selectedOrder->redeemed_details = DB::table('loyalty_histories')
        ->where('order_id', $id)
        ->where('type', 'redeemed')
        ->first();

    $this->dispatch('open-order-modal');
}
    public function closeOrder()
    {
        $this->selectedOrder = null;
    }

    public function render()
    {
        $now = now();

        $totalOrders = Order::count();
        $onlineOrdersCount = Order::where('order_type', 'online')->count();
        $onlineOrders = Order::where('order_type', 'online')->latest()->get();
        $offlineOrders = Order::where('order_type', '!=', 'online')->count();

        $pending = Order::where('order_status', 'Pending')->count();
        $confirmed = Order::where('order_status', 'Confirmed')->count();
        $processing = Order::where('order_status', 'Processing')->count();
        $shipped = Order::where('order_status', 'Shipped')->count();
        $outForDelivery = Order::where('order_status', 'Out for Delivery')->count();
        $delivered = Order::where('order_status', 'Delivered')->count();
        $cancelled = Order::where('order_status', 'Cancelled')->count();
        $returned = Order::where('order_status', 'Returned')->count();

        $paidRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $pendingRevenue = Order::where('payment_status', 'pending')->sum('total_amount');
        $cancelledRevenue = Order::where('order_status', 'Cancelled')->sum('total_amount');

        $totalStores = Store::count();
        $totalStaff = Employee::count();

        $stores = Store::withCount('employees')->get();

        foreach ($stores as $store) {
            $ordersQuery = Order::where('store_id', $store->id);

            $store->stats = [
                'today_revenue' => (clone $ordersQuery)
                    ->whereDate('created_at', today())
                    ->sum('total_amount'),

                'pending_orders' => (clone $ordersQuery)
                    ->where('order_status', 'Pending')
                    ->count(),

                'completed_orders' => (clone $ordersQuery)
                    ->where('order_status', 'Delivered')
                    ->count(),

                'cancelled_orders' => (clone $ordersQuery)
                    ->where('order_status', 'Cancelled')
                    ->count(),
            ];

            $store->recent_orders = (clone $ordersQuery)
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($order) {
                    $order->status_color = match ($order->payment_status) {
                        'completed' => 'success',
                        'pending' => 'warning',
                        default => 'secondary'
                    };
                    return $order;
                });

            $store->top_selling_products = DB::table('order_items')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->join('products', 'products.id', '=', 'order_items.product_id')
                ->where('orders.store_id', $store->id)
                ->select(
                    'products.name',
                    DB::raw('SUM(order_items.qty) as sales_count')
                )
                ->groupBy('products.name')
                ->orderByDesc('sales_count')
                ->limit(3)
                ->get();
            $store->managers = DB::table('managers')
                ->join('users', 'users.id', '=', 'managers.user_id')
                ->where('managers.store_id', $store->id)
                ->select('users.id', 'users.name')
                ->limit(3)
                ->get();
        }

        $onlineOrders = Order::where('order_type', 'online')->latest()->get();

        return view('livewire.super-admin.dashboard', compact(
            'totalOrders',
            'onlineOrders',
            'onlineOrdersCount',
            'offlineOrders',
            'pending',
            'confirmed',
            'processing',
            'shipped',
            'outForDelivery',
            'delivered',
            'cancelled',
            'returned',
            'paidRevenue',
            'pendingRevenue',
            'cancelledRevenue',
            'totalStores',
            'totalStaff',
            'stores',
            'onlineOrders'
        ));
    }
}
