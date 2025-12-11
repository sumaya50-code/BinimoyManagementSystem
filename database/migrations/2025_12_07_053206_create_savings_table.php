
 <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('savings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('member_id')->constrained('users')->onDelete('cascade');
                $table->decimal('balance', 15, 2)->default(0);
                $table->decimal('interest_rate', 5, 2)->default(5); // yearly %
                $table->enum('type', ['deposit', 'withdraw']);
                $table->decimal('amount', 15, 2);
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
                $table->timestamps();
            });
        }



        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('savings');
        }
    };
