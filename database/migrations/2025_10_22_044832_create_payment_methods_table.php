<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->boolean('is_health_card')->default(false);
            $table->softDeletes();
        });

        DB::table('payment_methods')->insert([
            ['name' => 'Cash', 'is_health_card' => false],
            ['name' => 'GCash', 'is_health_card' => false],
            ['name' => 'Maya', 'is_health_card' => false],
            ['name' => 'Bank Transfer', 'is_health_card' => false],
            ['name' => 'HMO', 'is_health_card' => true],
            ['name' => 'Medicard', 'is_health_card' => true],
            ['name' => 'Avega', 'is_health_card' => true],
            ['name' => 'Cocolife', 'is_health_card' => true],
            ['name' => 'PhilCare', 'is_health_card' => true],
        ]);

        Schema::create('invoices_has_payment_method', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('invoice_id');
            $table->string('reference_number');
            $table->float('amount_paid', 10, 2);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices_has_payment_method');
        Schema::dropIfExists('payment_methods');
    }
};
