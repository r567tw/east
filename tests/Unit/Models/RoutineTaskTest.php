<?php

namespace Tests\Unit\Models;

use App\Models\RoutineTask;
use PHPUnit\Framework\TestCase;

class RoutineTaskTest extends TestCase
{
    public function test_model_instantiable()
    {
        $model = new RoutineTask;
        $this->assertInstanceOf(RoutineTask::class, $model);
    }

    public function test_fillable()
    {
        $model = new \App\Models\RoutineTask([
            'title' => 'test',
            'description' => 'desc',
            'weeks_of_month' => 1,
            'day_of_week' => 1,
            'active' => true,
        ]);
        $this->assertEquals('test', $model->title);
        $this->assertEquals('desc', $model->description);
        $this->assertTrue($model->active);
    }

    public function test_get_target_date_for_this_month_returns_carbon()
    {
        $model = new \App\Models\RoutineTask([
            'weeks_of_month' => 1,
            'day_of_week' => 1,
        ]);
        $date = $model->getTargetDateForThisMonth();
        $this->assertInstanceOf(\Carbon\Carbon::class, $date);
    }
}
