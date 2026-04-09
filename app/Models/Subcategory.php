<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subcategory extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }

            if (!$model->slug) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    protected $fillable = [
        'store_id',
        'category_id',
        'created_by',
        'name',
        'slug',
        'description',
        'is_active'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Belongs to Store (integer id)
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // Belongs to Category (UUID)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Created by Admin (integer user id)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
