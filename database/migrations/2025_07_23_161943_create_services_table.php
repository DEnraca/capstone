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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('station_id');
            $table->unsignedBigInteger('department_id');
            $table->string('code',10);
            $table->string('name',10);
            $table->text('description',300)->nullable();
            $table->float('price', 8, 2)->default(0.00);
            $table->foreign('station_id')->references('id')->on('stations')->restrictOnDelete();
            $table->foreign('department_id')->references('id')->on('departments')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
