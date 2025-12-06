<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $categories = [
            'Fruits & Vegetables',
            'Dairy & Eggs',
            'Meat & Chicken',
            'Rice, Pasta & Grains',
            'Coffee & Tea',
            'Drinks & Water',
            'Snacks & Chocolate',
            'Cleaning Supplies',
            'Baby Products',
            'Pet Food',
            'Frozen Food',
            'Breakfast & Cereals',
        ];

        return [
            'name' => $this->faker->randomElement($categories),
            'is_active' => rand(0,1),
            'image'     => 'categories/default.png',
        ];
    }
}
