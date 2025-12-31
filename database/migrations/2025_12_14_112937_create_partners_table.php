<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('share_percentage', 5, 2)->default(0); // % share
            $table->decimal('invested_amount', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('partners');
    }
};
