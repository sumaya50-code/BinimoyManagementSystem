<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('cash_transactions')) {
            Schema::create('cash_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('cash_asset_id')->constrained('cash_assets')->cascadeOnDelete();
                $table->enum('type', ['inflow','outflow']);
                $table->decimal('amount', 15,2);
                $table->string('reference_type')->nullable();
                $table->unsignedBigInteger('reference_id')->nullable();
                $table->string('remarks')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('cash_transactions');
    }
};
