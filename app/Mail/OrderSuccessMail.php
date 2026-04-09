<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class OrderSuccessMail extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    public $items;
    public $pointsUsed;
    public $pointsEarned;
    public $logo;
    public $supportEmail;
    /**
     * Create a new message instance.
     */
    public function __construct($order, $items, $pointsUsed = 0, $pointsEarned = 0, $supportEmail = null)
    {
        $this->order = $order;
        $this->items = $items;
        $this->pointsUsed = $pointsUsed;
        $this->pointsEarned = $pointsEarned;
        $this->supportEmail = $supportEmail;
        if ($this->order->store_id) {
            $store = DB::table('store_settings')->where('store_id', $this->order->store_id)->first();
            $this->logo = $store ? $store->logo : null;
        } else {
            $this->logo = \App\Models\StoreSetting::first()->logo ?? null;
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Success Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order_invoice',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
