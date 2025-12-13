<?php

namespace Tests\Unit\Services;

use App\Models\RoutineTask;
use App\Services\RoutineTaskService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoutineTaskServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_instantiable()
    {
        $service = new RoutineTaskService;
        $this->assertInstanceOf(RoutineTaskService::class, $service);
    }

    public function test_get_tasks_for_this_week_returns_collection()
    {
        $fixedNow = \Carbon\Carbon::create(2025, 1, 6, 12, 0, 0); // 這天是週一
        \Carbon\Carbon::setTestNow($fixedNow);

        $dayOfWeek = $fixedNow->dayOfWeek;
        $task1 = RoutineTask::factory()->create([
            'active' => true,
            'weeks_of_month' => 2,
            'day_of_week' => 4,
        ]);
        $task2 = RoutineTask::factory()->create([
            'active' => true,
            'weeks_of_month' => 2,
            'day_of_week' => 3,
        ]);
        // 建立一筆不在本週的任務
        RoutineTask::factory()->create([
            'active' => true,
            'weeks_of_month' => 4,
            'day_of_week' => ($dayOfWeek + 1) % 7,
        ]);
        $service = new RoutineTaskService;
        $tasks = $service->getTasksForThisWeek();
        $this->assertCount(2, $tasks);
        $this->assertTrue($tasks->pluck('id')->contains($task1->id));
        $this->assertTrue($tasks->pluck('id')->contains($task2->id));
        \Carbon\Carbon::setTestNow(); // 還原
    }

    public function test_get_tasks_for_this_week_triggers_sort_callback()
    {
        $fixedNow = \Carbon\Carbon::create(2025, 1, 6, 12, 0, 0); // 週一
        \Carbon\Carbon::setTestNow($fixedNow);
        // 第一個任務：本月第二個週一
        $task1 = RoutineTask::factory()->create([
            'active' => true,
            'weeks_of_month' => 2,
            'day_of_week' => 6,
        ]);
        // 第二個任務：本月第二個週二
        $task2 = RoutineTask::factory()->create([
            'active' => true,
            'weeks_of_month' => 2,
            'day_of_week' => 4,
        ]);
        $service = new RoutineTaskService;
        $tasks = $service->getTasksForThisWeek()->values();
        // 應該是第二個週一在前（由近到遠）
        $this->assertEquals($task2->id, $tasks[0]->id);
        $this->assertEquals($task1->id, $tasks[1]->id);
        \Carbon\Carbon::setTestNow();
    }
}
