<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_proposal_id')->constrained()->cascadeOnDelete();
            $table->decimal('disbursed_amount', 15,2);
            $table->decimal('remaining_amount', 15,2);
            $table->enum('status', ['Active','Completed','Overdue'])->default('Active');
            $table->date('disbursement_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('loans');
    }
};
