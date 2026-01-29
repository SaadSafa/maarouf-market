<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_unverified_user_is_redirected_from_checkout(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get(route('checkout.index'));

        $response
            ->assertRedirect(route('verification.notice'))
            ->assertSessionHas('warning');
    }

    public function test_checkout_creates_order_with_discounted_total_and_clears_cart(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['is_active' => 1]);
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 100,
            'discount_price' => 80,
            'is_active' => 1,
        ]);

        $cart = Cart::create([
            'user_id' => $user->id,
            'session_id' => 'test-session',
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price_at_time' => 80,
        ]);

        $response = $this->actingAs($user)->post(route('checkout.confirm'), [
            'customer_name' => 'Test User',
            'customer_phone' => '123456',
            'address' => 'Test Address',
            'area' => 'Test Area',
            'note' => 'Leave at door',
        ]);

        $response
            ->assertRedirect(route('orders.index'))
            ->assertSessionHas('success');

        $order = Order::first();
        $this->assertNotNull($order);
        $this->assertSame('placed', $order->status);
        $this->assertEquals(160.0, (float) $order->total);

        $orderItem = $order->items()->first();
        $this->assertNotNull($orderItem);
        $this->assertSame(2, $orderItem->quantity);
        $this->assertEquals(80.0, (float) $orderItem->price);

        $this->assertSame(0, $cart->items()->count());
    }

    public function test_checkout_rolls_back_if_order_items_fail(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['is_active' => 1]);
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 50,
            'discount_price' => null,
            'is_active' => 1,
        ]);

        $cart = Cart::create([
            'user_id' => $user->id,
            'session_id' => 'test-session',
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price_at_time' => 50,
        ]);

        $this->withoutExceptionHandling();

        $originalDispatcher = \App\Models\OrderItem::getEventDispatcher();
        $dispatcher = new \Illuminate\Events\Dispatcher();
        \App\Models\OrderItem::setEventDispatcher($dispatcher);
        \App\Models\OrderItem::creating(function () {
            throw new \Exception('Order item failure');
        });

        try {
            $this->actingAs($user)->post(route('checkout.confirm'), [
                'customer_name' => 'Test User',
                'customer_phone' => '123456',
                'address' => 'Test Address',
                'area' => 'Test Area',
                'note' => 'Leave at door',
            ]);

            $this->fail('Expected exception was not thrown.');
        } catch (\Exception $e) {
            $this->assertSame(0, Order::count());
            $this->assertSame(1, CartItem::count());
        } finally {
            \App\Models\OrderItem::setEventDispatcher($originalDispatcher);
        }
    }
}
