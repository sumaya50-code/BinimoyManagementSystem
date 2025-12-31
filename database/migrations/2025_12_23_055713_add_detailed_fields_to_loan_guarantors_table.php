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
        Schema::table('loan_guarantors', function (Blueprint $table) {
            $table->text('declaration')->nullable();
            $table->string('guarantor_signature')->nullable();
            $table->enum('tip_sign', ['left', 'right'])->nullable();
            $table->string('employee_signature')->nullable();
            $table->string('manager_signature')->nullable();
            $table->string('authorized_person_name')->nullable();
            $table->string('authorized_person_signature')->nullable();
            $table->decimal('investment_received', 15, 2)->nullable();
            $table->string('investment_amount_words')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_guarantors', function (Blueprint $table) {
            //
        });
    }
};
