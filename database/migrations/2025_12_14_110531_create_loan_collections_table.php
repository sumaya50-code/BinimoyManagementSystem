<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('loan_collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_installment_id')->constrained()->cascadeOnDelete();
            $table->decimal('paid_amount', 15,2);
            $table->date('payment_date');
            $table->foreignId('collected_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('loan_collections');
    }
};
