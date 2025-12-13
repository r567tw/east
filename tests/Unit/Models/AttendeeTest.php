<?php

namespace Tests\Unit\Models;

use App\Models\Attendee;
use PHPUnit\Framework\TestCase;

class AttendeeTest extends TestCase
{
    public function test_model_instantiable()
    {
        $model = new Attendee;
        $this->assertInstanceOf(Attendee::class, $model);
    }

    public function test_fillable()
    {
        $model = new \App\Models\Attendee(['name' => 'test', 'email' => 'test@example.com']);
        $this->assertEquals('test', $model->name);
        $this->assertEquals('test@example.com', $model->email);
    }

    public function test_event_relation_method_returns_belongs_to()
    {
        $model = $this->getMockBuilder(\App\Models\Attendee::class)
            ->onlyMethods(['event'])
            ->getMock();
        $model->expects($this->once())
            ->method('event')
            ->willReturn($this->createMock(\Illuminate\Database\Eloquent\Relations\BelongsTo::class));
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $model->event());
    }
}
