<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_funds', function (Blueprint $table) {
            $table->id();
            $table->decimal('cash_in_hand', 15, 2)->default(0);
            $table->decimal('cash_in_bank', 15, 2)->default(0);
            $table->timestamp('last_updated')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_funds');
    }
};
