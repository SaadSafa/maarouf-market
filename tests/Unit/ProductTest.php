<?php

namespace Tests\Unit;

use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_effective_price_returns_discount_when_lower(): void
    {
        $product = new Product([
            'price' => 100,
            'discount_price' => 80,
        ]);

        $this->assertSame(80, $product->effective_price);
    }

    public function test_effective_price_falls_back_to_price(): void
    {
        $product = new Product([
            'price' => 100,
            'discount_price' => 120,
        ]);

        $this->assertSame(100, $product->effective_price);
    }
}
