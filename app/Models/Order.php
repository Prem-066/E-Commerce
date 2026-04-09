<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Order extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'admin_id',
        'store_id',
        'employee_id',
        'customer_name',
        'customer_last_name',
        'customer_phone',
        'customer_email',
        'customer_id',
        'order_number',
        'user_id',
        'created_by_name',
        'creator_role',
        'city',
        'address',
        'zip_code',
        'shipping_charges',
        'order_notes',
        'total_amount',
        'order_type',
        'order_status',
        'subtotal',
        'payment_status',
        'payment_method',
        'payment_id',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
