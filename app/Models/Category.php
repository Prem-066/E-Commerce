<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Auto UUID generate
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }

            // Auto slug generate
            if (!$model->slug) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    protected $fillable = [
        'store_id',
        'created_by',
        'name',
        'slug',
        'description',
        'image',
        'is_active'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Category belongs to Store (integer id)
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // Created by Admin (integer user id)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Has Many Subcategories (UUID relation)
    // Category.php મોડેલમાં
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id', 'id');
    }
}
