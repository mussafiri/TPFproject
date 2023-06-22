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
        Schema::create('member_dependants', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id');
            $table->string('fname');
            $table->string('mname');
            $table->string('lname');
            $table->string('gender');
            $table->string('dob');
            $table->string('phone')->default('NULL');
            $table->enum('relationship',['SPOUSE','CHILD','FATHER','MOTHER']);
            $table->enum('occupation',['NONE','STUDENT','FARMER','UNEMPLOYED','EMPLOYED','RETIRED','BUSINESS','PASTOR'])->default('NONE');
            $table->string('picture')->default('NULL');
            $table->string('marriagecert')->default('NULL');
            $table->string('birthcert')->default('NULL');
            $table->enum('status',['ACTIVE','SUSPENDED'])->default('ACTIVE');
            $table->enum('vital_status',['ALIVE','DECEASED'])->default('ALIVE');
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
        Schema::dropIfExists('member_dependants');
    }
};
