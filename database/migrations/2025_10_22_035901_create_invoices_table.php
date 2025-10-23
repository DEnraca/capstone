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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('percentage',10);
            $table->softDeletes();
        });

        DB::table('discounts')->insert([
            ['name' => 'Senior Citizen', 'percentage' => '20'],
            ['name' => 'PWD', 'percentage' => '20'],
        ]);

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->unsignedBigInteger('transaction_id');
            $table->float('total_amount', 10, 2);
            $table->float('total_discount', 10, 2)->default(0);
            $table->float('amount_paid', 10, 2)->default(0);
            $table->float('grand_total', 10, 2)->default(0);
            $table->float('change', 10, 2)->default(0);


            $table->unsignedBigInteger('discount_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->boolean('is_paid')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('discounts');
    }
};
