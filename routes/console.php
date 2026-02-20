<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:get-gold-price')->daily();
Schedule::command('app:fetch-astro')->daily();
