<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Station;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceDataDependencies extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::insert( [
            [
                'name' => 'Laboratory',
                'active' => true
            ],
            [
                'name' => 'X-Ray Laboratory',
                'active' => true
            ],
            [
                'name' => 'Heart Laboratory',
                'active' => true
            ]
        ]);


        Station::insert( [
            [
                'name' => 'Chemistry',
                'active' => true
            ],
            [
                'name' => 'Microscopy',
                'active' => true
            ],
            [
                'name' => 'Hematology',
                'active' => true
            ],
            [
                'name' => 'Bacteriology',
                'active' => true
            ],
            [
                'name' => 'Serology',
                'active' => true
            ],
            [
                'name' => 'Endocrinology',
                'active' => true
            ],
            [
                'name' => 'Heart',
                'active' => true
            ],
        ]);

    }
}
