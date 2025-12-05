<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // -----------------------------
        // 50 FIXED REAL PRODUCTS
        // -----------------------------
        $fixedProducts = [
            ['Fresh Apple', 1, 2.99],
            ['Banana', 1, 1.49],
            ['Orange Juice', 2, 4.50],
            ['Whole Milk 1L', 2, 1.99],
            ['Ayran 300ml', 2, 0.79],
            ['Chicken Breast 1kg', 3, 5.99],
            ['Beef Steak 1kg', 3, 14.99],
            ['Rice 5kg', 4, 3.99],
            ['Pasta Spaghetti 1kg', 4, 1.50],
            ['Olive Oil 1L', 4, 7.99],
            ['Sugar 1kg', 4, 1.20],
            ['Salt 500g', 4, 0.50],
            ['Tea Pack 100 bags', 5, 2.49],
            ['Nescafe 200g', 5, 5.99],
            ['Coca Cola 1.25L', 6, 1.00],
            ['Pepsi 1.25L', 6, 1.00],
            ['Water Bottle 1.5L', 6, 0.30],
            ['Chips Large', 7, 1.20],
            ['Chocolate Bar', 7, 0.79],
            ['Biscuit Pack', 7, 0.99],
            ['Detergent 3L', 8, 4.99],
            ['Dish Soap', 8, 1.50],
            ['Shampoo 400ml', 8, 3.50],
            ['Toothpaste', 8, 1.20],
            ['Toilet Paper (8 pcs)', 8, 2.99],
            ['Baby Diapers Size 4', 9, 8.99],
            ['Baby Wipes 80pcs', 9, 2.49],
            ['Cat Food 1kg', 10, 3.49],
            ['Dog Food 1kg', 10, 3.99],
            ['Frozen Pizza', 11, 3.50],
            ['Frozen Fries 2.5kg', 11, 2.99],
            ['Corn Flakes 500g', 12, 2.50],
            ['Honey 500g', 12, 4.99],
            ['Ketchup 500g', 12, 1.50],
            ['Mayonnaise 500g', 12, 1.80],
            ['Yogurt 1kg', 2, 2.49],
            ['Butter 200g', 2, 1.99],
            ['Cheese 500g', 2, 3.99],
            ['Tomato 1kg', 1, 1.19],
            ['Potato 1kg', 1, 0.99],
            ['Cucumber 1kg', 1, 1.49],
            ['Onion 1kg', 1, 0.89],
            ['Energy Drink', 6, 0.99],
            ['Ice Cream Cup', 6, 0.50],
            ['Instant Noodles', 4, 0.40],
            ['Vinegar 1L', 4, 1.20],
            ['Flour 2kg', 4, 1.80],
            ['Ground Beef 1kg', 3, 9.99],
            ['Tilapia Fish 1kg', 3, 6.99],
        ];

        foreach ($fixedProducts as $fp) {
            Product::create([
                'name' => $fp[0],
                'category_id' => $fp[1],
                'price' => $fp[2],
                'discount_price' => null,
                'stock' => rand(10, 200),
                'barcode' => Str::random(10),
                'description' => $faker->sentence(12),
                'image' => 'products/default.png',
            ]);
        }

        // -----------------------------
        // RANDOM PRODUCTS (100 example)
        // -----------------------------
        for ($i = 0; $i < 100; $i++) {
            Product::create([
                'name' => $faker->words(2, true),
                'category_id' => rand(1, 12),
                'price' => $faker->randomFloat(2, 0.5, 25),
                'discount_price' => rand(0, 1) ? $faker->randomFloat(2, 0.3, 20) : null,
                'stock' => rand(0, 500),
                'barcode' => Str::random(12),
                'description' => $faker->sentence(15),
                'image' => 'products/default.png',
            ]);
        }
    }
}
