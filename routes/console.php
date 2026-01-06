<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:get-gold-price')->hourly();
Schedule::command('app:fetch-astro')->daily();
Schedule::command('app:routine-reminder')->weeklyOn(0, '00:30'); // 每週日凌晨12:30
