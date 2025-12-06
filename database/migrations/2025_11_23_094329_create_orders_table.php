<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // CUSTOMER INFO
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('area')->nullable();
            $table->string('address')->nullable();

            // ORDER META
            $table->string('order_code')->nullable()->unique();
            $table->string('source')->nullable();                // app, whatsapp, phone, etc.
            $table->text('manager_notes')->nullable();

            // PAYMENT
            $table->enum('payment_method', ['cash', 'card', 'online'])
                  ->default('cash');

            // ORDER STATUS
            $table->enum('status', [
                'pending',
                'placed',
                'picking',
                'picked',
                'indelivery',
                'completed',
                'canceled'
            ])->default('placed');

            // FINANCIAL
            $table->decimal('total', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
