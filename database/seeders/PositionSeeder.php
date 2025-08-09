<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        Position::insert( [
            [
                'name' => 'Pathologist',
                'created_at' => now(),
            ],
            [
                'name' => 'Chief medtech',
                'created_at' => now(),
            ],
            [
                'name' => 'Specimen Collector',
                'created_at' => now(),
            ],
            [
                'name' => 'Phlebotomist',
                'created_at' => now(),
            ],
            [
                'name' => 'Cashier',
                'created_at' => now(),
            ],
            [
                'name' => 'Encoder',
                'created_at' => now(),
            ],
            [
                'name' => 'Diagnostic Laboratory and Imaging Test',
                'created_at' => now(),
            ],
            [
                'name' => 'HR/Admin',
                'created_at' => now(),
            ],
            [
                'name' => 'Medtech',
                'created_at' => now(),
            ],
        ]);
    }
}
