<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(rand(1,3)),
            'image' => fake()->imageUrl(360, 360, 'steel', true, 'stainless', true),
            'brand' => fake()->word(),
            'model' => fake()->word(),
            'width' => fake()->numberBetween(1,20) * 100,
            'depth' => fake()->numberBetween(1,20) * 100,
            'height' => fake()->numberBetween(1,20) * 100,
            'price' => fake()->numberBetween(1,10) * 50000 + fake()->numberBetween(1,10) * 100000,
            'qty' => fake()->numberBetween(1,5),
            'status' => fake()->randomElement(StatusEnum::activeCases()),
        ];
    }
}
