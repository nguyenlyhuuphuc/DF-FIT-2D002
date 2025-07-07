<?php

namespace Database\Factories;

use App\Models\ProductCategoryTest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $datas = ProductCategoryTest::all();
        $productCategoryIds = $datas->pluck('id')->toArray();
        
        return [
            'name' => fake()->name,
            'price' => fake()->randomFloat(2, 10, 99),
            'shipping' => fake()->randomDigitNotZero(),
            'weight' => fake()->randomFloat(2, 1, 10),
            'desptcriion' => fake()->randomHtml(2, 2),
            'status' => fake()->boolean(),
            'main_image' => fake()->imageUrl(640, 480, 'animals', true),
            'product_category_id' => fake()->randomElement($productCategoryIds)
        ];
    }
}
