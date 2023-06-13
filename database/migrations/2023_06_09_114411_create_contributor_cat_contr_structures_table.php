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
        Schema::create('contributor_cat_contr_structures', function (Blueprint $table) {
            $table->id();
            $table->integer('contributor_category_id');
            $table->decimal('contributor_contribution_rate', 32,2);
            $table->decimal('member_contribution_rate', 32,2);
            $table->integer('member_salutation_id');
            $table->enum('status',['ACTIVE','DORMANT'])->default('ACTIVE');
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
        Schema::dropIfExists('contributor_cat_contr_structures');
    }
};
