<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $faker = $this->faker;

        // Generate price and optional discount
        $price = $faker->randomFloat(2, 0.5, 40);
        $discount = $faker->boolean(30)     // 30% chance
                    ? $faker->randomFloat(2, 0.4, $price)
                    : null;

        return [
            'name'           => $faker->words(2, true),
            'category_id'    => rand(1, 2),          // You can change to your category IDs
            'price'          => $price,
            'discount_price' => $discount,
            'stock'          => rand(0, 300),
            'description'    => $faker->sentence(15),
            'image'          => 'products/default.png',
            'is_active'      => $faker->boolean(90),  // 90% products active
        ];
    }
}
