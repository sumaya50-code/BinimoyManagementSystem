<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('investment_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('partner_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('investment_no')->unique();
            $table->date('application_date');
            $table->decimal('applied_amount', 15,2);
            $table->decimal('approved_amount', 15,2)->nullable();
            $table->date('investment_date')->nullable();
            $table->string('business_name')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('trade_license_no')->nullable();
            $table->text('business_address')->nullable();
            $table->string('business_type')->nullable();
            $table->enum('status', ['pending','approved','rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('investment_applications');
    }
};
