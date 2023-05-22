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
            $table->id();
            $table->string('fname');
            $table->string('mname');
            $table->string('lname');
            $table->enum('gender', ['MALE','FEMALE']);
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('avatar')->default('NULL');
            $table->string('pwd');
            $table->string('dob');
            $table->string('physical_address');
            $table->integer('dept_id');
            $table->integer('designation_id');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->string('last_login')->default('NULL');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('status', ['ACTIVE','BLOCKED'])->default('ACTIVE');
            $table->enum('password_status', ['DEFAULT','ACTIVE','SUSPENDED'])->default('DEFAULT');
            $table->string('password_created_at')->default('NULL');
            $table->string('password_changed_at')->default('NULL');
            $table->rememberToken();
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
