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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('role_id')->constrained();
            $table->foreignId('school_id')->nullable()->constrained();
            $table->string('uid', 100)->comment('rfid unique identifier')->index()->nullable();
            $table->string('employee_code')->nullable();
            $table->string('department')->nullable();
            $table->string('position')->nullable();
            $table->string('firstname', 100);
            $table->string('middlename', 50)->nullable();
            $table->string('lastname', 100);
            $table->string('suffix', 50)->nullable();
            $table->string('gender', 50)->nullable();
            $table->string('avatar')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('birthdate')->nullable();
            $table->text('address')->nullable();
            $table->string('sms_access_token')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
