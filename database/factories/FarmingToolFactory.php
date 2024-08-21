<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FarmingTool>
 */
class FarmingToolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'type' => fake()->word(),
            'farmType' => fake()->word(),
            'farmActivity' => fake()->word(),
            'description' => fake()->sentence(),
            'cost' => fake()->randomFloat(2, 100, 10000),
            'costUnit' => fake()->randomElement(['PER_HECTAR', 'PER_HOUR', 'PER_DAY']),
            'vendor_id' => fake()->numberBetween(1, 50),
        ];
    }

    public function withVendor($vendorId)
    {
        return $this->state(function (array $attributes) use ($vendorId) {
            return [
                'vendor_id' => $vendorId,
            ];
        });
    }
}
