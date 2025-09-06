<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EloquentProduct>
 */
class EloquentProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->colorName() . " ink bucket",
            "description" => $this->faker->sentence(),
            "price" => $this->faker->randomFloat(2, 1, 100),
            "quantity" => $this->faker->randomNumber(2),
        ];
    }
}
