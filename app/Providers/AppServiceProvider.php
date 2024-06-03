<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
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
        if (Schema::hasTable('variables')) {
            $settings = DB::table('variables')->pluck('value', 'key');
        }
        else {
            $settings = [];
        }
        if (count($settings) > 0) {
            Config::set('services.twilio.sid', $settings['TWILIO_ACCOUNT_SID'] ?? config('services.twilio.sid'));
            Config::set('services.twilio.token', $settings['TWILIO_AUTH_TOKEN'] ?? config('services.twilio.token'));
            Config::set('services.twilio.whatsapp_from', $settings['TWILIO_WHATSAPP_FROM'] ?? config('services.twilio.whatsapp_from'));
        }
    }
}
