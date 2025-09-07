<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShowQueues extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dummy =$this->dummy();
        return view('public.queue-board', compact('dummy'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


     public function dummy(){
            $transactions = collect([
                [
                    'station' => 'Cashier',
                    'now_serving' => [
                        'number' => 'PWD-0002',
                        'name' => 'Marcus',
                    ],
                    'next_in_line' => [
                        ['number' => 'PP-0003', 'name' => 'Alice'],
                        ['number' => 'PP-0004', 'name' => 'Bob'],
                        ['number' => 'PP-0005', 'name' => 'Charlie'],
                        ['number' => 'PP-0006', 'name' => 'Diana'],
                        ['number' => 'PP-0007', 'name' => 'Ethan'],
                        ['number' => 'PP-0008', 'name' => 'Fiona'],
                        ['number' => 'PP-0009', 'name' => 'George'],
                    ],
                ],
                [
                    'station' => 'Chemistry',
                    'now_serving' => [
                        'number' => 'SC-0010',
                        'name' => 'Hannah',
                    ],
                    'next_in_line' => [
                        ['number' => 'SC-0011', 'name' => 'Ian'],
                        ['number' => 'SC-0012', 'name' => 'Jack'],
                        ['number' => 'SC-0013', 'name' => 'Karen'],
                        ['number' => 'SC-0014', 'name' => 'Leo'],
                        ['number' => 'SC-0015', 'name' => 'Mona'],
                        ['number' => 'SC-0016', 'name' => 'Nina'],
                        ['number' => 'SC-0017', 'name' => 'Oscar'],
                    ],
                ],
                [
                    'station' => 'Microscopy',
                    'now_serving' => [
                        'number' => 'MI-0020',
                        'name' => 'Paul',
                    ],
                    'next_in_line' => [
                        ['number' => 'MI-0021', 'name' => 'Quincy'],
                        ['number' => 'MI-0022', 'name' => 'Rachel'],
                        ['number' => 'MI-0023', 'name' => 'Steve'],
                        ['number' => 'MI-0024', 'name' => 'Tina'],
                        ['number' => 'MI-0025', 'name' => 'Uma'],
                        ['number' => 'MI-0026', 'name' => 'Victor'],
                        ['number' => 'MI-0027', 'name' => 'Wendy'],
                    ],
                ],
                [
                    'station' => 'Hematology',
                    'now_serving' => [
                        'number' => 'HE-0030',
                        'name' => 'Xander',
                    ],
                    'next_in_line' => [
                        ['number' => 'HE-0031', 'name' => 'Yara'],
                        ['number' => 'HE-0032', 'name' => 'Zane'],
                    ],
                ],
                [
                    'station' => 'Bacteriology',
                    'now_serving' => [
                        'number' => 'BA-0040',
                        'name' => 'Olivia',
                    ],
                    'next_in_line' => [], // station with no next in line
                ],
                [
                    'station' => 'Serology',
                    'now_serving' => [
                        'number' => 'SE-0050',
                        'name' => 'Peter',
                    ],
                    'next_in_line' => [
                        ['number' => 'SE-0051', 'name' => 'Quinn'],
                        ['number' => 'SE-0052', 'name' => 'Rita'],
                        ['number' => 'SE-0053', 'name' => 'Sam'],
                        ['number' => 'SE-0054', 'name' => 'Tracy'],
                        ['number' => 'SE-0055', 'name' => 'Uma'],
                        ['number' => 'SE-0056', 'name' => 'Victor'],
                        ['number' => 'SE-0057', 'name' => 'Wendy'],
                    ],
                ],
            ]);

        return $transactions;

    }
}
