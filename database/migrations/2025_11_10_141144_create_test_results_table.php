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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->softDeletes();
        });


        DB::table('results')->insert([
            [
                'name' => 'Normal',
            ],
            [
                'name' => 'abnormal',
            ],
            [
                'name' => 'Within Normal Limits',
            ],
            [
                'name' => 'Borderline',
            ],
            [
                'name' => 'Needs follow up',
            ],
            [
                'name' => 'Insufficient Sample',
            ],
            [
                'name' => 'Repeat Test Required',
            ],
            [
                'name' => 'Inconclusive',
            ],
            [
                'name' => 'Fit to work',
            ],
            [
                'name' => 'Not fit to work',
            ],
            [
                'name' => 'Fit with restrictions',
            ],
            [
                'name' => 'Pending medical clearance',
            ],
            [
                'name' => 'Not Applicable',
            ],
        ]);

        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_tests_id')->comment('related to patient tests');
            $table->unsignedBigInteger('result_id')->comment('related to patient tests');
            $table->longText('impressions', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_results');
        Schema::dropIfExists('results');
    }
};
