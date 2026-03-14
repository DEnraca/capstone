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
        //

        Schema::table('invoices_has_payment_method', function (Blueprint $table) {
            $table->float('amount_tendered')->nullable();
            $table->float('variation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices_has_payment_method', function (Blueprint $table) {
            $table->dropColumn('amount_tendered');
            $table->dropColumn('variation');
        });
    }
};
