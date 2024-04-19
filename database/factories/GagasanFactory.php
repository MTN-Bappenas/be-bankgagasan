<?php

namespace Database\Factories;

use Faker\Provider\Lorem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gagasan>
 */
class GagasanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            "title" => $this->faker->name,
            "description" => $this->faker->text(),
            "image" => $this->faker->imageUrl(),
            "status" => $this->faker->boolean,
            "category_id" => $this->faker->numberBetween(1, 4),
            "user_id" => $this->faker->numberBetween(1, 3),
        ];
    }
}
