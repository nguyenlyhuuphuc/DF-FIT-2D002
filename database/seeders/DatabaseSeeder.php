<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategoryTest;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(100)->create();
        ProductCategoryTest::factory(100)->create();
        Product::factory(10)->create();
        
        // ProductCategoryTest::factory()->create([
        //     'status' => 1,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        //     'ten' => 'Test Test'
        // ]);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'a@example.com',
        // ]);
    }
}
