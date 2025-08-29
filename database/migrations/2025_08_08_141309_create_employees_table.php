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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id',50)->unique();
            $table->string('last_name',50)->nullable();
            $table->string('first_name',50)->nullable();
            $table->string('middle_name',50)->nullable();
            $table->unsignedBigInteger('gender_id');
            $table->date('birthdate')->nullable();
            $table->string('mobile',12)->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('employment_type')->nullable();
            $table->date('date_hired')->nullable();
            $table->boolean('is_active')->default(true);
            $table->longText('notes',300)->nullable();
            $table->string('user_id',36)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
