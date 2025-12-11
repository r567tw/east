<?php

namespace App\Services;

use App\Models\RoutineTask;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class RoutineTaskService
{
    /**
     * 取得本週應執行的例行公事
     */
    public function getTasksForThisWeek(): Collection
    {
        $tasks = RoutineTask::where('active', true)->get();

        $startOfWeek = Carbon::now();
        $endOfWeek = Carbon::now()->addWeek();

        return $tasks->filter(function ($task) use ($startOfWeek, $endOfWeek) {
            $targetDate = $this->getTaskDateForThisMonth($task);

            return $targetDate->between($startOfWeek, $endOfWeek);
        })->sort(function ($a, $b) {
            // 根據本月的具體日期排序 (由近到遠)
            $dateA = $this->getTaskDateForThisMonth($a);
            $dateB = $this->getTaskDateForThisMonth($b);

            return $dateB->diffInDays($dateA);
        });
    }

    /**
     * 計算任務在本月的具體日期
     */
    protected function getTaskDateForThisMonth(RoutineTask $task): Carbon
    {
        $firstDay = Carbon::now()->startOfMonth();

        while ($firstDay->dayOfWeek !== $task->day_of_week) {
            $firstDay->addDay();
        }

        return $firstDay->copy()->addWeeks($task->weeks_of_month - 1);
    }
}
