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
        Schema::create('queue_checklists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('queue_id');
            $table->unsignedBigInteger('station_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('queue_statuses');
            $table->unsignedBigInteger('updated_by');
            $table->boolean('is_default_step');
            $table->string('step_name')->comment('patient_info, transaction, releasing', 'billing');
            $table->integer('sort_order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queue_checklists');
    }
};
