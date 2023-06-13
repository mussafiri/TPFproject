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
        Schema::create('contributor_members', function (Blueprint $table) {
            $table->id();
            $table->integer('contributor_id');
            $table->integer('member_id');
            $table->string('assigned_date')->default('NULL');
            $table->enum('status', ['ACTIVE', 'DORMANT'])->default('ACTIVE');
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
        Schema::dropIfExists('contributor_members');
    }
};
