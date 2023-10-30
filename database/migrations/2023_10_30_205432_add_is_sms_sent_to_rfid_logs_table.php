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
        Schema::table('rfid_logs', function (Blueprint $table) {
            $table->boolean('is_sms_sent')->default(false)->after('log_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rfid_logs', function (Blueprint $table) {
            $table->dropColumn('is_sms_sent');
        });
    }
};
