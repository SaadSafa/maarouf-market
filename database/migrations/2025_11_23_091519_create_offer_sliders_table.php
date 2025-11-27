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
        Schema::create('offer_sliders', function (Blueprint $table) {
            $table->string('image'); // banner image
            $table->string('title')->nullable(); // e.g. "Weekend Offers"
            $table->string('description')->nullable(); // short text if needed
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_sliders');
    }
};
