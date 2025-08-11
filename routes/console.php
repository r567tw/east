<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->everyMinute()->sendOutputTo(storage_path('logs/inspire.log'));

// Schedule::command('app:send-event-reminder')->daily();
Schedule::command('app:get-gold-price')->hourly();
Schedule::command('app:clean-invite-code')->daily();
