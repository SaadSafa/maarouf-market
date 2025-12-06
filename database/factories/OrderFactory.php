<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $faker = $this->faker;

        return [
            'user_id'        => User::inRandomOrder()->first()->id ?? User::factory(),

            'order_code'     => 'ORD-' . strtoupper(Str::random(6)),
            'source'         => $faker->randomElement(['app', 'website', 'phone', 'whatsapp']),
            'manager_notes'  => $faker->boolean(30) ? $faker->sentence(8) : null,

            'customer_name'  => $faker->name(),
            'customer_phone' => '03' . rand(100000, 999999),
            'address'        => $faker->streetAddress(),
            'area'           => $faker->randomElement(['Beirut', 'Saida', 'Tyre', 'Nabatieh', 'Tripoli', 'Zahle']),

            'total'          => $faker->randomFloat(2, 5, 200),

            'status'         => $faker->randomElement([
                'pending', 'placed', 'picking', 'picked',
                'indelivery', 'completed', 'canceled'
            ]),

            'payment_method' => $faker->randomElement(['cash', 'card', 'online']),

            'created_at'     => $faker->dateTimeBetween('-2 days', 'now'),
            'updated_at'     => now(),
        ];
    }
}
