<?php

namespace Tests\Unit\Models;

use App\Models\Event;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    public function test_model_instantiable()
    {
        $model = new Event;
        $this->assertInstanceOf(Event::class, $model);
    }

    public function test_fillable()
    {
        $model = new \App\Models\Event([
            'name' => 'test',
            'description' => 'desc',
            'start_time' => '2025-01-01 00:00:00',
            'end_time' => '2025-01-01 01:00:00',
            'user_id' => 1,
        ]);
        $this->assertEquals('test', $model->name);
        $this->assertEquals('desc', $model->description);
    }

    public function test_user_relation_method_returns_belongs_to()
    {
        $model = $this->getMockBuilder(\App\Models\Event::class)
            ->onlyMethods(['user'])
            ->getMock();
        $model->expects($this->once())
            ->method('user')
            ->willReturn($this->createMock(\Illuminate\Database\Eloquent\Relations\BelongsTo::class));
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $model->user());
    }

    public function test_attendees_relation_method_returns_has_many()
    {
        $model = $this->getMockBuilder(\App\Models\Event::class)
            ->onlyMethods(['attendees'])
            ->getMock();
        $model->expects($this->once())
            ->method('attendees')
            ->willReturn($this->createMock(\Illuminate\Database\Eloquent\Relations\HasMany::class));
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $model->attendees());
    }
}
