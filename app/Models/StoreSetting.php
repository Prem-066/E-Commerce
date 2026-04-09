<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'store_email',
        'store_phone',
        'store_address',
        'gst_number',
        'logo',
        'smtp_host',
        'smtp_port',
        'smtp_username',
        'smtp_password',
        'smtp_encryption',
        'mail_from_address',
        'mail_from_name',
        'email_enabled',
        'notification_enabled',
        'invoice_prefix',
        'currency'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
