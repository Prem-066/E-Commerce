<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'address',
        'office_address',
        'password',
        'profile_image',
        'loyalty_points',
        'phone',
        'email_verified_at',
        'remember_token',
        'selected_add',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
