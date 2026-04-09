<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'max_discount',
        'valid_from',
        'valid_until',
        'usage_limit',
        'is_active',
    ];

    // ડેટા ટાઇપ ઓટોમેટિક કન્વર્ટ કરવા માટે
    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
        'discount_value' => 'float',
        'min_order_amount' => 'float',
        'max_discount' => 'float',
    ];

    /**
     * કૂપન અત્યારે વેલિડ છે કે નહીં તે ચેક કરવા માટેની સ્કોપ મેથડ
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now());
    }
}
