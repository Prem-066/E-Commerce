<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'store_id',
        'admin_id',
        'phone',
        'address',
        'designation',
        'salary',
        'joining_date',
        'employment_type',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Boot Method for UUID
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($employee) {
            if (empty($employee->id)) {
                $employee->id = (string) Str::uuid();
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class,'store_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
