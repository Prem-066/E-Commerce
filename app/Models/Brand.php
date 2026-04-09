<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'store_id',
        'created_by',
        'name',
        'slug',
        'description',
        'logo',
        'is_active'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (!$model->getKey()) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
