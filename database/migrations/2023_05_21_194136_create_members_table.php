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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->integer('contributor_id');
            $table->enum('title',['MR','MS','MRS','DR','REV','PST','PROF','BISHOP']);
            $table->integer('member_salutation_id')->default(0);
            $table->string('fname');
            $table->string('mname');
            $table->string('lname');
            $table->enum('gender',['MALE','FEMALE'])->default('MALE');
            $table->string('member_code');
            $table->enum('occupation',['NONE','FARMER','UNEMPLOYED','EMPLOYED','RETIRED','BUSINESS','PASTOR']);
            $table->integer('id_type_id')->default(0);
            $table->string('id_number')->default('NULL');
            $table->string('dob');
            $table->string('service_start_at')->default('NULL');
            $table->string('join_at')->default('NULL');
            $table->enum('marital_status',['SINGLE','MARRIED','DIVORCED','WIDOW','SEPARATED']);
            $table->string('phone')->default('NULL');
            $table->string('email')->default('NULL');
            $table->decimal('income',32,2);
            $table->string('postal_address')->default('NULL');
            $table->string('physical_address')->default('NULL');
            $table->string('picture')->default('NULL');
            $table->string('id_attachment')->default('NULL');
            $table->string('member_signature')->default('NULL');
            $table->string('regform_attachment')->default('NULL');
            $table->enum('status',['ACTIVE','BLOCKED'])->default('ACTIVE');
            $table->string('password');
            $table->enum('password_status', ['DEFAULT','ACTIVE','SUSPENDED'])->default('DEFAULT');
            $table->string('password_changed_at')->default('NULL');
            $table->string('last_login')->default('NULL');
            $table->enum('vital_status', ['ALIVE','DECEASED'])->default('ALIVE');
            $table->integer('created_by');
            $table->integer('updated_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
