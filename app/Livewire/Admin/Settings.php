<?php

namespace App\Livewire\Admin;

use App\Models\store;
use App\Models\StoreSetting;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Settings extends Component
{
    use WithFileUploads;

    public $store;

    public $store_email, $store_phone, $store_address, $gst_number;
    public $smtp_host, $smtp_port, $smtp_username, $smtp_password, $smtp_encryption;
    public $mail_from_address, $mail_from_name;
    public $email_enabled = false;
    public $notification_enabled = false;
    public $invoice_prefix, $currency;

    public $logo;
    public $existing_logo;

    public function mount()
    {
        $this->store = store::where('admin_id', auth()->id())->firstOrFail();

        $settings = StoreSetting::firstOrCreate(
            ['store_id' => $this->store->id]
        );

        $this->fill($settings->toArray());
        $this->email_enabled = (bool) $settings->email_enabled;
        $this->notification_enabled = (bool) $settings->notification_enabled;
        $this->existing_logo = $settings->logo;
    }

    public function save()
    {
        $this->validate([
            'store_email' => 'nullable|email',
            'smtp_host' => 'nullable|string',
            'logo' => $this->logo instanceof \Illuminate\Http\UploadedFile ? 'image|max:2048' : 'nullable',
        ]);

        $data = $this->only([
            'store_email',
            'store_phone',
            'store_address',
            'gst_number',
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
        ]);

        // Process File Upload if a new file was selected
        if ($this->logo && !is_string($this->logo)) {
            // Delete old logo if it exists
            if ($this->existing_logo && Storage::disk('public')->exists($this->existing_logo)) {
                Storage::disk('public')->delete($this->existing_logo);
            }

            // Store new logo
            $path = $this->logo->store('logos', 'public');
            $data['logo'] = $path;

            // Update local state
            $this->existing_logo = $path;
            $this->logo = null; // Clear upload component
        }

        StoreSetting::updateOrCreate(
            ['store_id' => $this->store->id],
            $data
        );
        flash()->addSuccess('Settings Updated Successfully !');
    }

    #[Layout('layouts.admin')]
    #[Title('Settings')]
    public function render()
    {
        return view('livewire.admin.settings');
    }
}
