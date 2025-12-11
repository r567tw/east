<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SendEventReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends notifications to all event attendees that event starts soon';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('SendEventReminder command started!'.now().'-'.now()->addDay());
        $events = \App\Models\Event::with('attendees.user')
            ->whereBetween('start_time', [now(), now()->addDay()])
            ->get();

        $eventCount = $events->count();
        $eventLabel = Str::plural('event', $eventCount);

        $this->info("Found {$eventCount} {$eventLabel}.");

        $events->each(
            function ($event) {
                $event->attendees->each(
                    function ($attendee) use ($event) {
                        $attendee->user->notify(new \App\Notifications\EventReminderNotification($event));
                    }
                );
            }
        );

        $this->info('SendEventReminder command executed successfully!');
    }
}
