<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class ShortUrlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'url' => fake()->url(),
            'short' => fake()->lexify('??????'),
            'user_id' => User::factory()->create()->id,
            'expires_at' => fake()->dateTimeBetween('+1 month', '+2 months'),
        ];
    }
}
