<?php

namespace App\Listeners;

use App\Events\EventRegistered;
use App\Notifications\EventRegisteredNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEventRegisteredNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EventRegistered $event): void
    {
        $event->attendee->notify(new EventRegisteredNotification($event->attendee));
    }
}
