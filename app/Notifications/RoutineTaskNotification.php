<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Collection;

class RoutineTaskNotification extends Notification
{
    use Queueable;

    protected Collection $tasks;

    public function __construct(Collection $tasks)
    {
        $this->tasks = $tasks;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('每週例行公事提醒')
            ->view('emails.routine_reminder', [
                'tasks' => $this->tasks
            ]);
    }
}
