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

            // only loggedin users  
            $table->foreignId('user_id')
                        ->constrained('users')
                        ->onDelete('cascade');

            // CUSTOMER INFO
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('area');
            $table->string('address');
            $table->text('note')->nullable();

            // ORDER META
            $table->string('order_code')->nullable();
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
                'cancelled'
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
