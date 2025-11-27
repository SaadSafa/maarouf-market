<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade');

            $table->string('name');
            $table->longText('description')->nullable();

            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable(); // for offers

            $table->integer('stock')->default(0); // quantity in inventory

            $table->string('image')->nullable(); // main product image path

            $table->boolean('is_active')->default(true); // show/hide product
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
