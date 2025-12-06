<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Vegetables
            ['category_id' => 1, 'name' => 'Tomatoes (1kg)', 'price' => 45000, 'description' => 'Fresh Lebanese tomatoes.', 'image' => 'products/tomatoes.jpg'],
            ['category_id' => 1, 'name' => 'Potatoes (1kg)', 'price' => 35000, 'description' => 'Golden potatoes for cooking and frying.', 'image' => 'products/potatoes.jpg'],
            ['category_id' => 1, 'name' => 'Cucumbers (1kg)', 'price' => 40000, 'description' => 'Crunchy and fresh cucumbers.', 'image' => 'products/cucumbers.jpg'],

            // Fruits
            ['category_id' => 2, 'name' => 'Bananas (1kg)', 'price' => 55000, 'description' => 'Sweet bananas.', 'image' => 'products/bananas.jpg'],
            ['category_id' => 2, 'name' => 'Apples (1kg)', 'price' => 60000, 'description' => 'Fresh Lebanese apples.', 'image' => 'products/apples.jpg'],
            ['category_id' => 2, 'name' => 'Oranges (1kg)', 'price' => 48000, 'description' => 'Juicy oranges.', 'image' => 'products/oranges.jpg'],

            // Frozen
            ['category_id' => 3, 'name' => 'Frozen Fries (1kg)', 'price' => 100000, 'description' => 'Crispy frozen fries.', 'image' => 'products/fries.jpg'],
            ['category_id' => 3, 'name' => 'Chicken Nuggets (900g)', 'price' => 190000, 'description' => 'Golden chicken nuggets.', 'image' => 'products/nuggets.jpg'],

            // Snacks
            ['category_id' => 4, 'name' => 'Doritos Nacho Cheese', 'price' => 65000, 'description' => 'Crunchy nacho cheese flavor.', 'image' => 'products/doritos.jpg'],
            ['category_id' => 4, 'name' => 'Pringles Original', 'price' => 90000, 'description' => 'Classic pringles.', 'image' => 'products/pringles.jpg'],
            ['category_id' => 4, 'name' => 'Lays Salted', 'price' => 60000, 'description' => 'Lebanese favorite chips.', 'image' => 'products/lays.jpg'],

            // Drinks
            ['category_id' => 5, 'name' => 'Pepsi (2L)', 'price' => 50000, 'description' => 'Classic Pepsi.', 'image' => 'products/pepsi.jpg'],
            ['category_id' => 5, 'name' => 'Coca Cola (2L)', 'price' => 55000, 'description' => 'Refreshing taste.', 'image' => 'products/cocacola.jpg'],
            ['category_id' => 5, 'name' => 'Water (1.5L)', 'price' => 15000, 'description' => 'Pure drinking water.', 'image' => 'products/water.jpg'],

            // Dairy
            ['category_id' => 6, 'name' => 'Picon Cheese (32pcs)', 'price' => 160000, 'description' => 'Rich creamy cheese.', 'image' => 'products/picon.jpg'],
            ['category_id' => 6, 'name' => 'Labneh (1kg)', 'price' => 180000, 'description' => 'Fresh Lebanese labneh.', 'image' => 'products/labneh.jpg'],
            ['category_id' => 6, 'name' => 'Milk (1L)', 'price' => 35000, 'description' => 'Fresh dairy milk.', 'image' => 'products/milk.jpg'],

            // Meat
            ['category_id' => 7, 'name' => 'Chicken Breast (1kg)', 'price' => 220000, 'description' => 'Fresh chicken breast.', 'image' => 'products/chickenbreast.jpg'],
            ['category_id' => 7, 'name' => 'Minced Meat (1kg)', 'price' => 300000, 'description' => 'High quality minced meat.', 'image' => 'products/mincedmeat.jpg'],

            // Bakery
            ['category_id' => 8, 'name' => 'Arabic Bread', 'price' => 20000, 'description' => 'Fresh Lebanese bread.', 'image' => 'products/bread.jpg'],
            ['category_id' => 8, 'name' => 'Croissant Chocolate', 'price' => 25000, 'description' => 'Soft croissant with chocolate filling.', 'image' => 'products/croissant.jpg'],

            // Cleaning
            ['category_id' => 9, 'name' => 'Detergent (2L)', 'price' => 110000, 'description' => 'Powerful cleaning detergent.', 'image' => 'products/detergent.jpg'],
            ['category_id' => 9, 'name' => 'Dishwashing Liquid', 'price' => 35000, 'description' => 'Fresh citrus scent.', 'image' => 'products/dishwashing.jpg'],

            // Household
            ['category_id' => 10, 'name' => 'Toilet Paper (10 rolls)', 'price' => 90000, 'description' => 'Soft and durable.', 'image' => 'products/toiletpaper.jpg'],
            ['category_id' => 10, 'name' => 'Aluminum Foil', 'price' => 60000, 'description' => 'High quality foil.', 'image' => 'products/foil.jpg'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
