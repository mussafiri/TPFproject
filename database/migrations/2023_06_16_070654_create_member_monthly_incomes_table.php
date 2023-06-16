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
        Schema::create('member_monthly_incomes', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id');
            $table->decimal('member_monthly_income', 32,2);
            $table->string('contribution_date')->default('NULL');
            $table->enum('status',['CONTRIBUTED','DORMANT'])->default('CONTRIBUTED');
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_monthly_incomes');
    }
};
