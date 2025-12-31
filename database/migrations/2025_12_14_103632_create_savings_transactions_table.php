<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('savings_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('savings_account_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['deposit','withdrawal']);
            $table->decimal('amount', 15, 2);
            $table->string('remarks')->nullable();
            $table->enum('status', ['pending','approved','rejected'])->default('pending'); // manual approval
            $table->date('transaction_date');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('savings_transactions');
    }
};
