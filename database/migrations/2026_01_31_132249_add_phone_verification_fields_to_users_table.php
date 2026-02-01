<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->timestamp('phone_verified_at')->nullable()->after('phone');
        $table->string('phone_otp')->nullable()->after('phone_verified_at');
        $table->timestamp('phone_otp_expires_at')->nullable()->after('phone_otp');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'phone_verified_at',
            'phone_otp',
            'phone_otp_expires_at'
        ]);
    });
}
};
