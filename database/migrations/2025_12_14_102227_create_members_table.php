<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
       Schema::create('members', function (Blueprint $table) {
    $table->id();

    $table->string('member_no', 50)->unique();
    $table->string('name', 100);
    $table->string('guardian_name', 100)->nullable();
    $table->string('nid', 20)->unique();
    $table->string('phone', 20);
    $table->string('email', 100)->nullable()->unique();

    $table->text('present_address');
    $table->text('permanent_address')->nullable();

    $table->string('nominee_name', 100)->nullable();
    $table->string('nominee_relation', 50)->nullable();

    $table->enum('status', ['Active','Inactive'])->default('Active');
    $table->enum('gender', ['Male','Female','Other'])->nullable();
    $table->date('dob')->nullable();
    $table->enum('marital_status', ['Single','Married','Divorced','Widowed'])->nullable();

    $table->string('education', 100)->nullable();
    $table->tinyInteger('dependents')->nullable();

    $table->timestamps();
});

    }

    public function down(): void {
        Schema::dropIfExists('members');
    }
};
