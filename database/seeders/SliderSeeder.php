<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OfferSlider;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $sliders = [
            ['image' => 'sliders/offer1.jpg', 'title' => 'Fresh Vegetables', 'description' => 'Best prices on all greens!'],
            ['image' => 'sliders/offer2.jpg', 'title' => 'Weekend Deals', 'description' => 'Up to 40% discount!'],
            ['image' => 'sliders/offer3.jpg', 'title' => 'Snacks & Chips', 'description' => 'Your favorite snacks!'],
            ['image' => 'sliders/offer4.jpg', 'title' => 'Frozen Food Sale', 'description' => 'Save on frozen items.'],
            ['image' => 'sliders/offer5.jpg', 'title' => 'Daily Essentials', 'description' => 'Everything your home needs!'],
        ];

        foreach ($sliders as $slider) {
            OfferSlider::create($slider);
        }
    }
}
