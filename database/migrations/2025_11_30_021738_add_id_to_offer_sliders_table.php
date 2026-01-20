<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('offer_sliders', 'id')) {
            return;
        }

        if (DB::getDriverName() === 'sqlite') {
            Schema::create('offer_sliders_tmp', function (Blueprint $table) {
                $table->id();
                $table->string('image');
                $table->string('title')->nullable();
                $table->string('description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });

            DB::statement('INSERT INTO offer_sliders_tmp (image, title, description, is_active, created_at, updated_at) SELECT image, title, description, is_active, created_at, updated_at FROM offer_sliders');

            Schema::drop('offer_sliders');
            Schema::rename('offer_sliders_tmp', 'offer_sliders');
            return;
        }

        Schema::table('offer_sliders', function (Blueprint $table) {
            $table->id()->first();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        if (!Schema::hasColumn('offer_sliders', 'id')) {
            return;
        }

        if (DB::getDriverName() === 'sqlite') {
            Schema::create('offer_sliders_tmp', function (Blueprint $table) {
                $table->string('image');
                $table->string('title')->nullable();
                $table->string('description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });

            DB::statement('INSERT INTO offer_sliders_tmp (image, title, description, is_active, created_at, updated_at) SELECT image, title, description, is_active, created_at, updated_at FROM offer_sliders');

            Schema::drop('offer_sliders');
            Schema::rename('offer_sliders_tmp', 'offer_sliders');
            return;
        }

        Schema::table('offer_sliders', function (Blueprint $table) {
            $table->dropColumn('id');
        });
    }
};
