<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('cash_assets')) {
            Schema::create('cash_assets', function (Blueprint $table) {
                $table->id();
                $table->enum('type', ['cash_in_hand','bank'])->default('cash_in_hand');
                $table->string('name')->nullable();
                $table->decimal('balance', 15,2)->default(0);
                $table->string('details')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('cash_assets', function (Blueprint $table) {
                if (!Schema::hasColumn('cash_assets', 'details')) $table->string('details')->nullable();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('cash_assets');
    }
};
