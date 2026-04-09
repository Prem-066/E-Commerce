<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'website_name',
        'logo',
        'favicon',
        'contact_email',
        'contact_phone',
        'address',
        'time_zone',
        'default_language',
        'currency_code',
        'currency_symbol',
        'enable_cod',
        'enable_free_shipping',
        'free_shipping_threshold',
        'default_gst_percentage',
        'enable_2fa',
        'terms_and_conditions',
        'privacy_policy',
        'return_policy',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
        'facebook_link',
        'instagram_link',
        'twitter_link',
        'maintenance_mode'
    ];
}
