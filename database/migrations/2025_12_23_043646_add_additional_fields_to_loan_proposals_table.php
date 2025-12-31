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
        Schema::table('loan_proposals', function (Blueprint $table) {
            $table->date('loan_proposal_date')->nullable();
            $table->decimal('savings_balance', 15, 2)->nullable();
            $table->decimal('dps_balance', 15, 2)->nullable();
            $table->decimal('approved_amount_audit', 15, 2)->nullable();
            $table->decimal('approved_amount_manager', 15, 2)->nullable();
            $table->decimal('approved_amount_area', 15, 2)->nullable();
            $table->string('auditor_signature')->nullable();
            $table->string('manager_signature')->nullable();
            $table->string('area_manager_signature')->nullable();
            $table->date('date_approved')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_proposals', function (Blueprint $table) {
            $table->dropColumn(['loan_proposal_date', 'savings_balance', 'dps_balance', 'approved_amount_audit', 'approved_amount_manager', 'approved_amount_area', 'auditor_signature', 'manager_signature', 'area_manager_signature', 'date_approved']);
        });
    }
};
