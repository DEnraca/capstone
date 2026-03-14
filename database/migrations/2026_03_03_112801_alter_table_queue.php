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
        Schema::table('queues', function (Blueprint $table) {
            $table->dropUnique('queues_queue_number_unique');
        });
        Schema::table('invoices_has_payment_method', function (Blueprint $table) {
            $table->string('reference_number',100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('queues', function (Blueprint $table) {
            $table->unique('queue_number');
        });

        Schema::table('invoices_has_payment_method', function (Blueprint $table) {
            $table->string('reference_number',100)->change();
        });
    }
};
