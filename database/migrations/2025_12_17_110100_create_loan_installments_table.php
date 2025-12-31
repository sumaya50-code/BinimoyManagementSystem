<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('loan_installments')) {
            Schema::create('loan_installments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('loan_id')->constrained()->cascadeOnDelete();
                $table->integer('installment_no');
                $table->date('due_date');
                $table->decimal('principal_amount', 15,2)->default(0);
                $table->decimal('interest_amount', 15,2)->default(0);
                $table->decimal('amount', 15,2)->default(0); // principal + interest
                $table->decimal('paid_amount', 15,2)->default(0);
                $table->decimal('penalty_amount', 15,2)->default(0);
                $table->enum('status', ['pending','paid','overdue'])->default('pending');
                $table->dateTime('paid_at')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('loan_installments', function (Blueprint $table) {
                if (!Schema::hasColumn('loan_installments', 'installment_no')) $table->integer('installment_no');
                if (!Schema::hasColumn('loan_installments', 'principal_amount')) $table->decimal('principal_amount', 15,2)->default(0);
                if (!Schema::hasColumn('loan_installments', 'interest_amount')) $table->decimal('interest_amount', 15,2)->default(0);
                if (!Schema::hasColumn('loan_installments', 'paid_amount')) $table->decimal('paid_amount', 15,2)->default(0);
                if (!Schema::hasColumn('loan_installments', 'penalty_amount')) $table->decimal('penalty_amount', 15,2)->default(0);
                if (!Schema::hasColumn('loan_installments', 'paid_at')) $table->dateTime('paid_at')->nullable();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('loan_installments');
    }
};
