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
        Schema::create('contributors', function (Blueprint $table) {
            $table->id();
            $table->integer('section_id');
            $table->string('contributor_code');
            $table->string('name');
            $table->integer('contributor_type_id');
            $table->string('postal_address');
            $table->string('physical_address');
            $table->string('phone');
            $table->string('email');
            $table->enum('status',['ACTIVE','SUSPENDED']);
            $table->string('reg_form')->default('NULL');
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
        Schema::dropIfExists('contributors');
    }
};
