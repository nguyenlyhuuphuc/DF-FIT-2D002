<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductCategoryTest>
 */
class ProductCategoryTestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        $slug = Str::slug($name);

        return [
            'status' => fake()->boolean(),
            'created_at' => now(),
            'updated_at' => now(),
            'name' => $name,
            'slug' => $slug
        ];
    }
}
