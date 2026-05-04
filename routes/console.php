<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule auto-cancel expired orders every hour
Schedule::command('orders:cancel-expired')
    ->hourly()
    ->withoutOverlapping()
    ->runInBackground();

// Schedule auto-check Paylabs payment status every 5 minutes
Schedule::command('paylabs:check-status')
    ->everyFiveMinutes()
    ->withoutOverlapping()
    ->runInBackground();
