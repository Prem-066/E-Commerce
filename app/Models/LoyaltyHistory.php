<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyHistory extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'order_id', 'order_item_id', 'points', 'type', 'description', 'status'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
