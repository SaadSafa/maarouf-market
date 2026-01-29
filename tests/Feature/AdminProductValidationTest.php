<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_requires_category_id(): void
    {
        $admin = User::factory()->create();
        $admin->role = 'admin';
        $admin->save();

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'name' => 'Test Product',
            'price' => 10,
            'stock' => 5,
            'description' => 'Test',
        ]);

        $response->assertSessionHasErrors(['category_id']);
        $this->assertSame(0, Product::count());
    }

    public function test_product_barcode_must_be_unique(): void
    {
        $admin = User::factory()->create();
        $admin->role = 'admin';
        $admin->save();

        $category = Category::factory()->create();

        Product::create([
            'name' => 'Existing',
            'category_id' => $category->id,
            'price' => 10,
            'discount_price' => null,
            'stock' => 5,
            'image' => null,
            'is_active' => 1,
            'barcode' => 'ABC123',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'name' => 'Duplicate',
            'category_id' => $category->id,
            'price' => 12,
            'stock' => 2,
            'description' => 'Test',
            'barcode' => 'ABC123',
        ]);

        $response->assertSessionHasErrors(['barcode']);
    }
}
