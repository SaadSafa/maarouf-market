<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Vegetables', 'image' => 'categories/vegetables.jpg'],
            ['name' => 'Fruits', 'image' => 'categories/fruits.jpg'],
            ['name' => 'Frozen', 'image' => 'categories/frozen.jpg'],
            ['name' => 'Snacks', 'image' => 'categories/snacks.jpg'],
            ['name' => 'Drinks', 'image' => 'categories/drinks.jpg'],
            ['name' => 'Dairy', 'image' => 'categories/dairy.jpg'],
            ['name' => 'Meat', 'image' => 'categories/meat.jpg'],
            ['name' => 'Bread & Bakery', 'image' => 'categories/bakery.jpg'],
            ['name' => 'Cleaning Products', 'image' => 'categories/cleaning.jpg'],
            ['name' => 'Household Items', 'image' => 'categories/household.jpg'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
