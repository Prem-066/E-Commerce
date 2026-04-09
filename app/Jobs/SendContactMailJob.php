<?php

namespace App\Jobs;

use App\Livewire\SuperAdmin\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use App\Mail\ContactMail;
use App\Mail\ContactThankYouMail;
use App\Models\Settings as ModelsSettings;

class SendContactMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $settings = ModelsSettings::first();
        $adminEmail = $settings->contact_email;

        Mail::to($adminEmail)->send(
            new ContactMail($this->data)
        );

        Mail::to($this->data['email'])->send(new ContactThankYouMail($this->data));
    }
}
