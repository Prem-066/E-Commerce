<?php

namespace App\Http\Controllers;

use App\Jobs\SendOrderEmailJob;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Employee;
use App\Mail\OrderSuccessMail;
use App\Models\Manager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Str;

class PaymentController extends Controller
{
    public function handleSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::retrieve($sessionId);
        $meta = $session->metadata;
        $userId = $meta['user_id'] ?? null;

        $exists = Order::where('payment_id', $sessionId)->exists();
        if ($exists) {
            return $this->redirectBasedOnRole($userId);
        }

        if ($session->payment_status === 'paid') {

            $staff = Employee::where('user_id', $userId)->first();

            if (!$staff) {
                $staff = Manager::where('user_id', $userId)->first();
            }

            if (!$staff) {
                return redirect('login')->with('error', 'Staff or Manager details not found!');
            }

            $order = Order::create([
                'admin_id'       => $staff->admin_id,
                'store_id'       => $staff->store_id,
                'employee_id'    => $userId,
                'user_id'    => $userId,
                'total_amount'   => $session->amount_total / 100,
                'order_number'  => 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(8)),
                'order_type'     => 'offline',
                'order_status'        => 'Delivered',
                'payment_status'        => 'paid',
                'payment_method' => 'online',
                'payment_id'     => $sessionId,
                'customer_name'  => $meta['customer_name'] ?? 'Guest',
                'customer_phone' => $meta['customer_phone'] ?? null,
                'customer_email' => $meta['customer_email'] ?? null,
            ]);

            $cartItems = json_decode($meta['cart_data'], true);
            foreach ($cartItems as $id => $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $id,
                    'qty'        => $item['qty'],
                    'price'      => $item['price'],
                    'status'     => 'Delivered',
                ]);
                Product::find($id)->decrement('stock', $item['qty']);
            }

            if (!empty($meta['customer_email'])) {

                DB::afterCommit(function () use ($order, $cartItems, $meta) {
                    SendOrderEmailJob::dispatch(
                        $order->id,
                        $cartItems,
                        $meta['customer_email']
                    );
                });
            }

            return $this->redirectBasedOnRole($userId)->with('success', 'Online Payment Received!');
        }

        return $this->redirectBasedOnRole($userId)->with('error', 'Payment Failed!');
    }

    private function redirectBasedOnRole($userId)
    {
        $user = \App\Models\User::find($userId);

        if ($user && $user->hasRole('Store Manager')) {
            return redirect()->route('store.manager.pos');
        }

        return redirect()->route('employee.pos'); // એમ્પ્લોયીના POS રૂટનું નામ
    }
}
