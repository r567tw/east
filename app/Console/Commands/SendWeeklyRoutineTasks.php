<?php

namespace App\Console\Commands;

use App\Notifications\RoutineTaskNotification;
use App\Services\RoutineTaskService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendWeeklyRoutineTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:routine-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = app(RoutineTaskService::class);
        $tasks = $service->getTasksForThisWeek();

        // 使用 Notification 機制
        Notification::route('mail', 'r567tw@gmail.com')
            ->notify(new RoutineTaskNotification($tasks));
    }
}
