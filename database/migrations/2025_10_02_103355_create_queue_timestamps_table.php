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
        Schema::create('queue_timestamps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('queue_checklists');
            $table->unsignedBigInteger('queue_statuses');
            $table->dateTime('first_called_at')->nullable();
            $table->dateTime('recalled_last_at')->nullable();
            $table->dateTime('completed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queue_timestamps');
    }
};
