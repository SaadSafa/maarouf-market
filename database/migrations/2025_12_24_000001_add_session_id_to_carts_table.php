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
        Schema::table('carts', function (Blueprint $table) {
            $table->string('session_id', 100)->nullable()->after('user_id');

            // Allow guest carts; requires doctrine/dbal for change() on some drivers.
            $table->foreignId('user_id')->nullable()->change();

            $table->unique('session_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropUnique(['session_id']);
            $table->dropColumn('session_id');

            // Revert to required user_id
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
