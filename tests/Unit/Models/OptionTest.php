<?php

namespace Tests\Unit\Models;

use App\Models\Option;
use Tests\TestCase;

class OptionTest extends TestCase
{
    public function test_model_instantiable()
    {
        $model = new Option;
        $this->assertInstanceOf(Option::class, $model);
    }

    public function test_fillable()
    {
        $model = new Option(['name' => 'test']);
        $this->assertEquals('test', $model->name);
    }

    public function test_poll_relation_method_returns_belongs_to()
    {
        $option = new Option(['name' => 'test']);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $option->poll());
    }

    public function test_votes_relation_method_returns_has_many()
    {
        $option = new Option(['name' => 'test']);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $option->votes());
    }
}
