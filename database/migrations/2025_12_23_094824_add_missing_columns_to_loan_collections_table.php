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
        Schema::table('loan_collections', function (Blueprint $table) {
            if (!Schema::hasColumn('loan_collections', 'amount')) {
                $table->decimal('amount', 15, 2)->nullable();
            }
            if (!Schema::hasColumn('loan_collections', 'collector_id')) {
                $table->foreignId('collector_id')->nullable()->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('loan_collections', 'status')) {
                $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            }
            if (!Schema::hasColumn('loan_collections', 'verified_by')) {
                $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('loan_collections', 'verified_at')) {
                $table->timestamp('verified_at')->nullable();
            }
            if (!Schema::hasColumn('loan_collections', 'transaction_date')) {
                $table->date('transaction_date')->nullable();
            }
            if (!Schema::hasColumn('loan_collections', 'remarks')) {
                $table->string('remarks')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_collections', function (Blueprint $table) {
            //
        });
    }
};
