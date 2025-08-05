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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->integer('status')->default(1)->comment('1: Pending, 2: Confirmed, 3: Cancelled, 4: Completed');
            $table->string('email',100)->nullable();
            $table->string('last_name',50)->nullable();
            $table->string('first_name',50)->nullable();
            $table->string('middle_name',50)->nullable();
            $table->string('mobile',12)->nullable();
            $table->longText('message',300)->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
