<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tenant>
 */
class TenantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Tenant::class;

    public function definition(): array
    {
        return [
            'plan_id' => Plan::factory(),
            'cnpj' => uniqid().date('YmdHis'),
            'name' => fake()->unique()->name,
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}
