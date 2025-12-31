<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->string('journal_type')->nullable();
            $table->unsignedBigInteger('transactionable_id')->nullable();
            $table->string('transactionable_type')->nullable();
            $table->text('narration')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('ledger_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journal_id');
            $table->unsignedBigInteger('account_id');
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('credit', 15, 2)->default(0);
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('chart_of_accounts')->onDelete('restrict');
        });
    }

    public function down(): void {
        Schema::dropIfExists('ledger_entries');
        Schema::dropIfExists('journals');
    }
};
