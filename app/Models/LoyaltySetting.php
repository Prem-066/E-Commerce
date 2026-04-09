<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltySetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'enable_loyalty',
        'points_per_hundred',
        'point_value_in_currency',
        'min_redeem_points',
        'referrer_reward_points',
        'referee_reward_points',
    ];
}
