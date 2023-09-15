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
        Schema::create('rfid_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid', 100)->comment('rfid unique identifier');
            $table->string('type', 50);
            $table->timestamp('log_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfid_logs');
    }
};
