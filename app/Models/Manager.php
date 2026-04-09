<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Manager extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_id',
        'admin_id',
        'phone',
        'address',
        'salary',
        'joining_date',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class,'store_id');
    }

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
