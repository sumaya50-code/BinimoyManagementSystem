<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('loan_guarantors', function (Blueprint $table) {
            $table->text('liabilities')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_guarantors', function (Blueprint $table) {
            $table->decimal('liabilities', 15, 2)->nullable()->change();
        });
    }
};
