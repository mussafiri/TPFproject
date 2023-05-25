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
        Schema::create('contributor_contact_people', function (Blueprint $table) {
            $table->id();
            $table->integer('contributor_id');
            $table->string('name');
            $table->string('title');
            $table->string('phone');
            $table->string('email');
            $table->enum('status',['ACTIVE','SUSPENDED']);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributor_contact_people');
    }
};
