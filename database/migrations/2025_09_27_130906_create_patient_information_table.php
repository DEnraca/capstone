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
