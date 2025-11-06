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

        Schema::create('report_kind', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        DB::table('report_kind')->insert([
            [
                'name' => 'Patient Information',
            ],
            [
                'name' => 'Transactions',
            ],
            [
                'name' => 'Invoices',
            ],
            [
                'name' => 'Appointments',
            ]
        ]);

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->date('from');
            $table->date('to');
            $table->string('range')->comment('1: Today, 2: This Week, 3: Last 7 Days, 4: Last 15 Days, 5: Last 30 Days, 6: Custom');
            $table->integer('type')->comment('1: Excel, 2: PDF');
            $table->unsignedBigInteger('report_kind_id');
            $table->unsignedBigInteger('generated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
        Schema::dropIfExists('report_kind');
    }
};
