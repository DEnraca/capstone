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
        Schema::create('med_tech_has_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('med_tech_id');
            $table->unsignedBigInteger('service_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('med_tech_has_services');
    }
};
