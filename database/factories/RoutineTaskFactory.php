<?php

namespace Database\Factories;

use App\Models\RoutineTask;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoutineTaskFactory extends Factory
{
    protected $model = RoutineTask::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->sentence(6),
            'weeks_of_month' => $this->faker->numberBetween(1, 5),
            'day_of_week' => $this->faker->numberBetween(0, 6),
            'active' => $this->faker->boolean(),
        ];
    }
}
