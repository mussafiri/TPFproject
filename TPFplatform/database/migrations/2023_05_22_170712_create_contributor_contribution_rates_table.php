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
        Schema::create('contributor_contribution_rates', function (Blueprint $table) {
            $table->id();
            $table->integer('contributor_type_id');
            $table->integer('salutation_id');
            $table->integer('contribution_rate');
            $table->enum('status', ['ACTIVE','SUSPENDED'])->default('ACTIVE');
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributor_contribution_rates');
    }
};
