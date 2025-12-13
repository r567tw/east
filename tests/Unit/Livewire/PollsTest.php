<?php

namespace Tests\Unit\Livewire;

use App\Livewire\Polls;
use PHPUnit\Framework\TestCase;

class PollsTest extends TestCase
{
    public function test_component_instantiable()
    {
        $component = new Polls;
        $this->assertInstanceOf(Polls::class, $component);
    }

    public function test_vote_calls_votes_create()
    {
        $option = $this->getMockBuilder(\App\Models\Option::class)
            ->onlyMethods(['votes'])
            ->getMock();
        $votesRelation = $this->getMockBuilder(\Illuminate\Database\Eloquent\Relations\HasMany::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['create'])
            ->getMock();
        $votesRelation->expects($this->once())->method('create');
        $option->expects($this->once())->method('votes')->willReturn($votesRelation);
        $component = new \App\Livewire\Polls;
        $component->vote($option);
    }
}
