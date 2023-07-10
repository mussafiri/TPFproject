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
        Schema::create('arrear_details', function (Blueprint $table) {
            $table->id();
            $table->integer('arrear_id');
            $table->integer('contributor_id');
            $table->integer('member_id');
            $table->decimal('member_monthly_income', 32,2);
            $table->decimal('member_contribution', 32,2);
            $table->decimal('contributor_contribution', 32,2);
            $table->decimal('arrear_amount', 32,2);
            $table->decimal('arrear_penalty_amount', 32,2);
            $table->string('payment_ref_no')->default('NULL');
            $table->string('payment_proof')->default('NULL');
            $table->enum('status',['ACTIVE','SUSPENDED','CLOSED','ON PAYMENT']  )->default('ACTIVE');
            $table->enum('processing_status',['ACTIVE','PENDING','SUSPENDED','CLOSED','ON PAYMENT','SUSPEND REJECTED','CLOSURE REJECTED'])->default('ACTIVE');
            $table->integer('closed_by')->default(0);
            $table->string('closed_at')->default('NULL');
            $table->integer('suspended_by')->default(0);
            $table->string('suspended_at')->default('NULL');
            $table->integer('suspend_approved_by')->default(0);
            $table->string('suspend_approved_at')->default('NULL');
            $table->integer('suspend_rejected_reason_id')->default(0);
            $table->integer('suspend_rejected_by')->default(0);
            $table->string('suspend_rejected_at')->default('NULL');
            $table->string('suspend_reject_reason')->default('NULL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arrear_details');
    }
};
