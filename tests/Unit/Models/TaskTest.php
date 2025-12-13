<?php

namespace Tests\Unit\Models;

use App\Models\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function test_model_instantiable()
    {
        $model = new Task;
        $this->assertInstanceOf(Task::class, $model);
    }

    public function test_completed_cast_to_boolean()
    {
        $model = \App\Models\Task::factory()->make(['completed' => 1]);
        $this->assertTrue($model->completed);
        $model = \App\Models\Task::factory()->make(['completed' => 0]);
        $this->assertFalse($model->completed);
    }
}
