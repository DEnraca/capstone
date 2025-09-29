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
        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments','email')) {
                $table->dropColumn('email');
            }
            if (Schema::hasColumn('appointments','last_name')) {
                $table->dropColumn('last_name');
            }
            if (Schema::hasColumn('appointments','first_name')) {
                $table->dropColumn('first_name');
            }
            if (Schema::hasColumn('appointments','mobile')) {
                $table->dropColumn('mobile');
            }
            if (Schema::hasColumn('appointments','middle_name')) {
                $table->dropColumn('middle_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('email',100)->nullable();
            $table->string('last_name',50)->nullable();
            $table->string('first_name',50)->nullable();
            $table->string('middle_name',50)->nullable();
            $table->string('mobile',12)->nullable();
        });
    }
};
