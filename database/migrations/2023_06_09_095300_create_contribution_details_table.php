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
        Schema::create('contribution_details', function (Blueprint $table) {
            $table->id();
            $table->integer('contribution_id');
            $table->integer('contributor_id');
            $table->integer('member_id');
            $table->decimal('member_monthly_income', 32,2);
            $table->decimal('member_contribution', 32,2);
            $table->decimal('contributor_contribution', 32,2);
            $table->string('payment_ref_no')->default('NULL');
            $table->string('payment_proof')->default('NULL');
            $table->decimal('member_topup', 32,2);
            $table->enum('status',['ACTIVE','WITHDRAWN'])->default('ACTIVE');
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
        Schema::dropIfExists('contribution_details');
    }
};
