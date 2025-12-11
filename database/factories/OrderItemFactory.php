<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();

        return [
            'order_id'   => Order::inRandomOrder()->first()->id,
            'product_id' => $product->id,
            'quantity'   => fake()->numberBetween(1, 5),
            'price'      => $product->price,
        ];
    }
}
