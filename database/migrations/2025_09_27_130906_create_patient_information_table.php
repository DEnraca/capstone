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
        Schema::create('patient_information', function (Blueprint $table) {
            $table->id();
            $table->string('pat_id',50)->unique();
            $table->string('last_name',50);
            $table->string('first_name',50);
            $table->string('middle_name',50)->nullable();
            $table->string('mobile',12)->nullable();
            $table->date('dob')->nullable();
            $table->string('user_id',36)->nullable();

            $table->unsignedBigInteger('address_id')->nullable();
            $table->unsignedBigInteger('gender')->nullable();
            $table->unsignedBigInteger('civil_status')->nullable();

            $table->timestamps();
        });
    }

    //     <!--
//     first_name
//     last_name
//     middle_name
//     address
//     gender
//     civil_status
//     email
//     dob
//     contact_number
//     pass

// -->

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_information');
    }
};
