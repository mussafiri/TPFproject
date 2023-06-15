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
        Schema::create('contributor_income_trackers', function (Blueprint $table) {
            $table->id();
            $table->integer('contributor_id');
            $table->decimal('contributor_monthly_income', 32,2);
            $table->string('start_date')->default('NULL');
            $table->string('end_date')->default('NULL');
            $table->enum('status',['ACTIVE','DORMANT'])->default('ACTIVE');
            $table->integer('updated_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributor_income_trackers');
    }
};
