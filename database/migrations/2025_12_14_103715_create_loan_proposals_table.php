<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('loan_proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->decimal('proposed_amount', 15, 2);
            $table->decimal('approved_amount', 15, 2)->nullable();
            $table->enum('status', ['pending','approved','rejected'])->default('pending');
            $table->string('business_type')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('loan_proposals');
    }
};
