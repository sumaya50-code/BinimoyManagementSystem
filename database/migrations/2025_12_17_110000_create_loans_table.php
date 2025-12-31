<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('loans')) {
            Schema::create('loans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('loan_proposal_id')->nullable()->constrained('loan_proposals')->cascadeOnDelete();
                $table->foreignId('member_id')->nullable()->constrained()->cascadeOnDelete();

                $table->decimal('loan_amount', 15, 2);
                $table->decimal('disbursed_amount', 15,2)->default(0);
                $table->decimal('remaining_amount', 15,2)->default(0);
                $table->decimal('interest_rate', 5,2)->default(0);

                $table->integer('installment_count')->default(0);
                $table->enum('installment_type', ['daily','weekly','monthly'])->default('monthly');

                $table->date('disbursement_date')->nullable();
                $table->enum('status', ['pending','approved','disbursed','closed','rejected'])->default('pending');
                $table->text('remarks')->nullable();

                // audit fields
                $table->foreignId('created_by')->nullable();
                $table->foreignId('approved_by')->nullable();

                $table->timestamps();
            });
        } else {
            // table already exists - add missing columns if necessary
            Schema::table('loans', function (Blueprint $table) {
                if (!Schema::hasColumn('loans', 'disbursed_amount')) $table->decimal('disbursed_amount', 15,2)->default(0);
                if (!Schema::hasColumn('loans', 'remaining_amount')) $table->decimal('remaining_amount', 15,2)->default(0);
                if (!Schema::hasColumn('loans', 'interest_rate')) $table->decimal('interest_rate', 5,2)->default(0);
                if (!Schema::hasColumn('loans', 'installment_count')) $table->integer('installment_count')->default(0);
                if (!Schema::hasColumn('loans', 'installment_type')) $table->enum('installment_type', ['daily','weekly','monthly'])->default('monthly');
                if (!Schema::hasColumn('loans', 'disbursement_date')) $table->date('disbursement_date')->nullable();
                if (!Schema::hasColumn('loans', 'status')) $table->enum('status', ['pending','approved','disbursed','closed','rejected'])->default('pending');
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('loans');
    }
};
