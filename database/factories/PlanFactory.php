<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Plan::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word,
            'price' => 89.0,
            'description' => fake()->sentence,
        ];
    }
}
