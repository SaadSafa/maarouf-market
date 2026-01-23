<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_add_discounted_product_and_price_snapshot_is_effective_price(): void
    {
        $category = Category::factory()->create(['is_active' => 1]);
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 100,
            'discount_price' => 80,
            'is_active' => 1,
        ]);

        $response = $this->post(route('cart.add', $product->id), [
            'quantity' => 2,
        ]);

        $response->assertOk()->assertJson(['success' => true]);

        $cart = Cart::first();
        $this->assertNotNull($cart);

        $item = $cart->items()->first();
        $this->assertNotNull($item);
        $this->assertSame($product->id, $item->product_id);
        $this->assertSame(2, $item->quantity);
        $this->assertEquals(80.0, (float) $item->price_at_time);
    }
}
