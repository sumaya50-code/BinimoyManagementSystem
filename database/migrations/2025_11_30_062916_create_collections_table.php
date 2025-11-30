<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->foreignId('loan_id')->nullable()->constrained('loans')->nullOnDelete();
            $table->foreignId('savings_account_id')->nullable()->constrained('savings_accounts')->nullOnDelete();
            $table->foreignId('collected_by')->constrained('users')->cascadeOnDelete(); // Field Officer
            $table->date('date');
            $table->decimal('amount', 15, 2);
            $table->enum('type', ['loan', 'savings']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
