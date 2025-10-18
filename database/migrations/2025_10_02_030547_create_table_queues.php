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
        Schema::dropIfExists('queues');

        Schema::create('priority_type', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        DB::table('priority_type')
            ->insert([
                [
                    'id' => 1,
                    'name' => 'Pregnant',
                ],
                [
                    'id' => 2,
                    'name' => 'Senior Citizen',
                ],
                [
                    'id' => 3,
                    'name' => 'Person with Disability (PWD)',
                ],
            ]);

            Schema::create('queue_type', function (Blueprint $table) {
                $table->id();
                $table->string('name');
            });

            DB::table('queue_type')
                ->insert([
                    [
                        'id' => 1,
                        'name' => 'Appointment',
                    ],
                    [
                        'id' => 2,
                        'name' => 'Walk-in',
                    ],
                    [
                        'id' => 3,
                        'name' => 'Priority Lane',
                    ],
                ]);

            Schema::create('queue_statuses', function (Blueprint $table) {
                $table->id();
                $table->string('name');
            });

            DB::table('queue_statuses')
                ->insert([
                    [
                        'id' => 1,
                        'name' => 'Pending',
                    ],
                    [
                        'id' => 2,
                        'name' => 'Processing',
                    ],
                    [
                        'id' => 3,
                        'name' => 'Paused',
                    ],
                    [
                        'id' => 4,
                        'name' => 'Completed',
                    ],
                    [
                        'id' => 5,
                        'name' => 'Removed',
                    ],
                ]);

        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->string('queue_number')->unique();
            $table->unsignedBigInteger('priority_type_id')->nullable();
            $table->unsignedBigInteger('queue_type_id')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->dateTime('queue_start');
            $table->dateTime('queue_end')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queue_type');
        Schema::dropIfExists('queue_statuses');
        Schema::dropIfExists('priority_type');
        Schema::dropIfExists('queues');
    }
};
