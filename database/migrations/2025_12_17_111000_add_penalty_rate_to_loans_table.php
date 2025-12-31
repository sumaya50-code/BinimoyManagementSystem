<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (Schema::hasTable('loans') && !Schema::hasColumn('loans', 'penalty_rate')) {
            Schema::table('loans', function (Blueprint $table) {
                $table->decimal('penalty_rate', 5,2)->default(0.5)->after('interest_rate'); // percent per period
            });
        }
    }

    public function down(): void {
        if (Schema::hasTable('loans') && Schema::hasColumn('loans', 'penalty_rate')) {
            Schema::table('loans', function (Blueprint $table) {
                $table->dropColumn('penalty_rate');
            });
        }
    }
};
