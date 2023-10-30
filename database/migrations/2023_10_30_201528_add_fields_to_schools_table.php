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
        Schema::table('schools', function (Blueprint $table) {
            $table->boolean('is_sms_enabled')->default(false)->after('banner');
            $table->integer('max_user_sms_per_day')->default(0)->after('is_sms_enabled');
            $table->integer('max_sms_credits')->default(0)->after('max_user_sms_per_day');
            $table->integer('sms_credits_used')->default(0)->after('max_sms_credits');
            $table->text('sms_applicable_role_ids')->after('sms_credits_used');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            //
        });
    }
};
