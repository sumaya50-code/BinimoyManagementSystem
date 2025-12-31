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
        Schema::table('loans', function (Blueprint $table) {
            $table->dropForeign(['loan_proposal_id']);
            $table->unsignedBigInteger('loan_proposal_id')->nullable()->change();
            $table->foreign('loan_proposal_id')->references('id')->on('loan_proposals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropForeign(['loan_proposal_id']);
            $table->unsignedBigInteger('loan_proposal_id')->nullable(false)->change();
            $table->foreign('loan_proposal_id')->references('id')->on('loan_proposals')->onDelete('cascade');
        });
    }
};
