<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->json('channels')->nullable();
            $table->string('to')->nullable();
            $table->text('body');
            $table->enum('status', ['pending','sent','failed'])->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('notification_logs');
    }
};
