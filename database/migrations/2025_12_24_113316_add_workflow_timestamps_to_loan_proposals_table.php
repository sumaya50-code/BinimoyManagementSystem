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
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('audited_at')->nullable();
            $table->timestamp('manager_approved_at')->nullable();
            $table->timestamp('area_manager_approved_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_proposals', function (Blueprint $table) {
            $table->dropColumn(['submitted_at', 'audited_at', 'manager_approved_at', 'area_manager_approved_at']);
        });
    }
};
