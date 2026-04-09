<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSuccessMail;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class SendOrderEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $orderId;
    public $cart;
    public $email;
    public $pointsUsed;
    public $pointsEarned;
    public function __construct($orderId, $cart, $email, $pointsUsed = 0, $pointsEarned = 0)
    {
        $this->orderId = $orderId;
        $this->cart = $cart;
        $this->email = $email;
        $this->pointsUsed = $pointsUsed;
        $this->pointsEarned = $pointsEarned;
    }

    public function handle(): void
    {
        $order = Order::find($this->orderId);

        if (!$order) {
            \Log::error("Order not found for email: " . $this->orderId);
            return;
        }

        $superadmin = DB::table('settings')->first();
        $store = DB::table('stores')->where('id', $order->store_id)->first();

        $supportEmail = $store->email
            ?? ($superadmin->contact_email ?? 'support@example.com');

        Mail::to($this->email)->send(
            new OrderSuccessMail(
                $order,
                $this->cart,
                $this->pointsUsed,
                $this->pointsEarned,
                $supportEmail
            )
        );
    }
}
