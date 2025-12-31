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
            $table->string('applicant_signature')->nullable();
            $table->string('employee_signature')->nullable();
            $table->string('audited_verified')->nullable();
            $table->string('verified_by_manager')->nullable();
            $table->string('verified_by_area_manager')->nullable();
            $table->string('authorized_signatory_signature')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_proposals', function (Blueprint $table) {
            //
        });
    }
};
