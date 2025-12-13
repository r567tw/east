<?php

namespace Tests\Unit\Models;

use App\Models\Vote;
use PHPUnit\Framework\TestCase;

class VoteTest extends TestCase
{
    public function test_model_instantiable()
    {
        $model = new Vote;
        $this->assertInstanceOf(Vote::class, $model);
    }

    public function test_option_relation_method_returns_belongs_to()
    {
        $model = $this->getMockBuilder(\App\Models\Vote::class)
            ->onlyMethods(['option'])
            ->getMock();
        $model->expects($this->once())
            ->method('option')
            ->willReturn($this->createMock(\Illuminate\Database\Eloquent\Relations\BelongsTo::class));
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $model->option());
    }
}
