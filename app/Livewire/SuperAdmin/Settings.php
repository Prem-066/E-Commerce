<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use App\Models\Settings as ModelsSettings;
use Illuminate\Support\Facades\Auth;

class Settings extends Component
{
    use WithFileUploads;

    public $website_name, $contact_email, $contact_phone, $address;
    public $logo, $old_logo, $favicon, $old_favicon;
    public $time_zone, $default_language, $currency_code, $currency_symbol;

    public $enable_cod = false, $enable_free_shipping = false, $free_shipping_threshold = 0;
    public $default_gst_percentage = 0, $enable_2fa = false, $maintenance_mode = false;

    public $terms_and_conditions, $privacy_policy, $return_policy;

    public $mail_host, $mail_port, $mail_username, $mail_password, $mail_encryption;
    public $mail_from_address, $mail_from_name;

    public $facebook_link, $instagram_link, $twitter_link;

    public function mount()
    {
        $setting = ModelsSettings::first();

        if ($setting) {
            $this->website_name = $setting->website_name;
            $this->contact_email = $setting->contact_email;
            $this->contact_phone = $setting->contact_phone;
            $this->address = $setting->address;
            $this->old_logo = $setting->logo;
            $this->old_favicon = $setting->favicon;
            $this->time_zone = $setting->time_zone;
            $this->default_language = $setting->default_language;
            $this->currency_code = $setting->currency_code;
            $this->currency_symbol = $setting->currency_symbol;

            $this->enable_cod = (bool)$setting->enable_cod;
            $this->enable_free_shipping = (bool)$setting->enable_free_shipping;
            $this->free_shipping_threshold = $setting->free_shipping_threshold;
            $this->default_gst_percentage = $setting->default_gst_percentage;
            $this->enable_2fa = (bool)$setting->enable_2fa;
            $this->maintenance_mode = (bool)$setting->maintenance_mode;

            $this->terms_and_conditions = $setting->terms_and_conditions;
            $this->privacy_policy = $setting->privacy_policy;
            $this->return_policy = $setting->return_policy;

            $this->mail_host = $setting->mail_host;
            $this->mail_port = $setting->mail_port;
            $this->mail_username = $setting->mail_username;
            $this->mail_password = $setting->mail_password;
            $this->mail_encryption = $setting->mail_encryption;
            $this->mail_from_address = $setting->mail_from_address;
            $this->mail_from_name = $setting->mail_from_name;

            $this->facebook_link = $setting->facebook_link;
            $this->instagram_link = $setting->instagram_link;
            $this->twitter_link = $setting->twitter_link;
        }
    }

    public function saveSettings()
    {
        $this->validate([
            'website_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'logo' => 'nullable|image|max:1024',
            'favicon' => 'nullable|image|max:1024',
            'contact_phone' => 'nullable|string',
            'currency_code' => 'required|string|max:10',
            'mail_from_address' => 'nullable|email',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'website_name' => $this->website_name,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'address' => $this->address,
            'time_zone' => $this->time_zone,
            'default_language' => $this->default_language,
            'currency_code' => $this->currency_code,
            'currency_symbol' => $this->currency_symbol,
            'enable_cod' => $this->enable_cod,
            'enable_free_shipping' => $this->enable_free_shipping,
            'free_shipping_threshold' => $this->free_shipping_threshold,
            'default_gst_percentage' => $this->default_gst_percentage,
            'enable_2fa' => $this->enable_2fa,
            'maintenance_mode' => $this->maintenance_mode,
            'terms_and_conditions' => $this->terms_and_conditions,
            'privacy_policy' => $this->privacy_policy,
            'return_policy' => $this->return_policy,
            'mail_host' => $this->mail_host,
            'mail_port' => $this->mail_port,
            'mail_username' => $this->mail_username,
            'mail_password' => $this->mail_password,
            'mail_encryption' => $this->mail_encryption,
            'mail_from_address' => $this->mail_from_address,
            'mail_from_name' => $this->mail_from_name,
            'facebook_link' => $this->facebook_link,
            'instagram_link' => $this->instagram_link,
            'twitter_link' => $this->twitter_link,
        ];

        if ($this->logo) {
            $data['logo'] = $this->logo->store('settings', 'public');
            $this->old_logo = $data['logo'];
        }

        if ($this->favicon) {
            $data['favicon'] = $this->favicon->store('settings', 'public');
            $this->old_favicon = $data['favicon'];
        }

        ModelsSettings::updateOrCreate(['id' => 1], $data);

        flash()->addSuccess('Settings updated successfully!');
    }
    #[Layout('layouts.admin')]
    #[Title('Super Admin')]
    public function render()
    {
        return view('livewire.super-admin.settings');
    }
}
