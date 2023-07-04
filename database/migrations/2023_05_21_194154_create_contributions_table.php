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
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->integer('section_id')->default(0);
            $table->string('contribution_period')->default('NULL');
            $table->integer('total_contributors')->default(0);
            $table->integer('total_members')->default(0);
            $table->decimal('contribution_amount', 32,2);
            $table->integer('payment_mode_id')->default(0);
            $table->string('payment_ref_no')->default('NULL');
            $table->string('payment_date')->default('NULL');
            $table->string('payment_proof')->default('NULL');
            $table->enum('status',['ACTIVE','SUSPENDED'])->default('ACTIVE');
            $table->enum('processing_status',['PENDING','APPROVED','POSTED','APPROVAL REJECTED','POSTING REJECTED'])->default('PENDING');
            $table->string('approved_by')->default(0);
            $table->string('approved_at')->default('NULL');
            $table->string('approval_rejected_by')->default(0);
            $table->string('approval_rejected_at')->default('NULL');
            $table->string('approval_reject_reason')->default('NULL');
            $table->string('posted_by')->default(0);
            $table->string('posted_at')->default('NULL');
            $table->string('posting_rejected_by')->default(0);
            $table->string('posting_rejected_at')->default('NULL');
            $table->string('posting_reject_reason')->default('NULL');
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
        Schema::dropIfExists('contributions');
    }
};
