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
        Schema::create('employment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        DB::table('employment_types')->insert([
            ['name' =>'Regular'],
            ['name' =>'Contractual'],
            ['name' =>'Part-Time'],
            ['name' =>'On-Call'],
            ['name' =>'On the Job Training (OJT)'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employment_types');
    }
};
