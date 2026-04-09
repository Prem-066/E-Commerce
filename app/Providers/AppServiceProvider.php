<?php

namespace App\Providers;

use App\Models\Settings;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use App\Models\Setting; // તમારા મોડેલનું નામ જે હોય તે
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $settings = Settings::first();
        View::share('settings', $settings);
        Paginator::useBootstrapFive();

        if (Schema::hasTable('settings')) {
            $settings = Settings::first();

            if ($settings) {
                $data = [
                    'driver'            => 'smtp',
                    'host'              => $settings->mail_host,
                    'port'              => $settings->mail_port,
                    'from'              => [
                        'address' => $settings->mail_from_address,
                        'name'    => $settings->mail_from_name,
                    ],
                    'encryption'        => $settings->mail_encryption,
                    'username'          => $settings->mail_username,
                    'password'          => $settings->mail_password,
                    'timeout'           => null,
                    'auth_mode'         => null,
                ];

                Config::set('mail.mailers.smtp', array_merge(config('mail.mailers.smtp'), $data));
                Config::set('mail.from.address', $settings->mail_from_address);
                Config::set('mail.from.name', $settings->mail_from_name);
                Config::set('mail.mailers.smtp.username', $settings->mail_username);
                Config::set('mail.mailers.smtp.password', $settings->mail_password);

                if ($settings->time_zone) {
                    Config::set('app.timezone', $settings->time_zone);
                    date_default_timezone_set($settings->time_zone);
                }
            }
        }
    }
}
