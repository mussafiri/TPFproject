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
        Schema::create('arrear_penalty_payments', function (Blueprint $table) {
            $table->id();
            $table->string('arrear_id')->default('NULL');
            $table->integer('section_id')->default(0);
            $table->integer('arrear_detail_id')->default(0);
            $table->decimal('pay_amount', 32,2);
            $table->integer('payment_mode_id')->default(0);
            $table->string('payment_ref_no')->default('NULL');
            $table->string('payment_date')->default('NULL');
            $table->string('payment_proof')->default('NULL');
            $table->enum('type',['SECTION PAY','MEMBER PAY'])->default('SECTION PAY');
            $table->enum('status',['PENDING','COMPLETED','REJECTED'])->default('PENDING');
            $table->enum('processing_status',['PENDING','APPROVED','APPROVAL REJECTED'])->default('PENDING');
            $table->string('approved_by')->default(0);
            $table->string('approved_at')->default('NULL');
            $table->integer('rejected_reason_id')->default(0);
            $table->string('rejected_by')->default(0);
            $table->string('rejected_at')->default('NULL');
            $table->string('reject_reason')->default('NULL');
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
        Schema::dropIfExists('arrear_penalty_payments');
    }
};
