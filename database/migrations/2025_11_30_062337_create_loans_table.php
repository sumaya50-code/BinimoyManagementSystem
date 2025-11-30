<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->string('loan_no')->unique();
            $table->decimal('principal_amount', 15, 2);
            $table->decimal('interest_rate', 5, 2); // percentage
            $table->decimal('total_payable', 15, 2);
            $table->enum('installment_type', ['daily', 'weekly', 'monthly'])->default('monthly');
            $table->decimal('installment_amount', 15, 2);
            $table->integer('duration_months');
            $table->date('start_date');
            $table->enum('status', ['pending', 'approved', 'active', 'completed', 'overdue'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
