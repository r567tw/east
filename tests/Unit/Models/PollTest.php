<?php

namespace Tests\Unit\Models;

use App\Models\Poll;
use Tests\TestCase;

class PollTest extends TestCase
{
    public function test_model_instantiable()
    {
        $model = new Poll;
        $this->assertInstanceOf(Poll::class, $model);
    }

    public function test_fillable()
    {
        $model = new \App\Models\Poll(['title' => 'test']);
        $this->assertEquals('test', $model->title);
    }

    public function test_options_relation_method_returns_has_many()
    {
        $model = new Poll(['title' => 'test']);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $model->options());
    }
}
