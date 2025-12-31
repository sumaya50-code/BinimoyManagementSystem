<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('loan_collections')) {
            Schema::create('loan_collections', function (Blueprint $table) {
                $table->id();
                $table->foreignId('loan_installment_id')->constrained('loan_installments')->cascadeOnDelete();
                $table->foreignId('collector_id')->nullable(); // field officer / user id
                $table->decimal('amount', 15,2);
                $table->enum('status', ['pending','verified','rejected'])->default('pending');
                $table->foreignId('verified_by')->nullable();
                $table->timestamp('verified_at')->nullable();
                $table->date('transaction_date')->nullable();
                $table->string('remarks')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('loan_collections', function (Blueprint $table) {
                if (!Schema::hasColumn('loan_collections', 'collector_id')) $table->foreignId('collector_id')->nullable();
                if (!Schema::hasColumn('loan_collections', 'status')) $table->enum('status', ['pending','verified','rejected'])->default('pending');
                if (!Schema::hasColumn('loan_collections', 'verified_by')) $table->foreignId('verified_by')->nullable();
                if (!Schema::hasColumn('loan_collections', 'transaction_date')) $table->date('transaction_date')->nullable();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('loan_collections');
    }
};
