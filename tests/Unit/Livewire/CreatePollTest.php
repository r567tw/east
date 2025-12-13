<?php

namespace Tests\Unit\Livewire;

use App\Livewire\CreatePoll;
use Tests\TestCase;

class CreatePollTest extends TestCase
{
    public function test_component_instantiable()
    {
        $component = new CreatePoll;
        $this->assertInstanceOf(CreatePoll::class, $component);
    }

    public function test_add_option_adds_empty_string()
    {
        $component = new \App\Livewire\CreatePoll;
        $component->options = ['foo'];
        $component->addOption();
        $this->assertEquals(['foo', ''], $component->options);
    }

    public function test_remove_option_removes_by_index()
    {
        $component = new \App\Livewire\CreatePoll;
        $component->options = ['foo', 'bar', 'baz'];
        $component->removeOption(1);
        $this->assertEquals(['foo', 'baz'], array_values($component->options));
    }

    public function test_updated_calls_validate_only()
    {
        $component = $this->getMockBuilder(\App\Livewire\CreatePoll::class)
            ->onlyMethods(['validateOnly'])
            ->getMock();
        $component->expects($this->once())
            ->method('validateOnly')
            ->with('title');
        $component->updated('title');
    }

    public function test_create_poll_calls_validate_dispatch_and_reset()
    {
        $component = $this->getMockBuilder(\App\Livewire\CreatePoll::class)
            ->onlyMethods(['validate', 'dispatch', 'reset'])
            ->getMock();
        $component->title = 'My Poll';
        $component->options = ['A', 'B'];
        $component->expects($this->once())->method('validate');
        $component->expects($this->once())->method('dispatch')->with('pollCreated');
        $component->expects($this->once())->method('reset')->with(['title', 'options']);

        $component->createPoll();
        $this->assertTrue(true);
    }
}
