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
        Schema::table('previous_loans', function (Blueprint $table) {
            $table->foreignId('loan_proposal_id')->constrained()->onDelete('cascade');
            $table->integer('installment_no')->nullable();
            $table->decimal('loan_amount', 10, 2)->nullable();
            $table->date('disbursement_date')->nullable();
            $table->date('repayment_date')->nullable();
            $table->date('probable_repayment_date')->nullable();
            $table->enum('loan_status', ['active', 'completed', 'defaulted'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('previous_loans', function (Blueprint $table) {
            $table->dropForeign(['loan_proposal_id']);
            $table->dropColumn([
                'loan_proposal_id',
                'installment_no',
                'loan_amount',
                'disbursement_date',
                'repayment_date',
                'probable_repayment_date',
                'loan_status'
            ]);
        });
    }
};
