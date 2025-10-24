<?php

namespace App\Http\Controllers;

use App\Models\QueueCall;
use App\Models\QueueChecklist;
use Illuminate\Http\Request;

class ShowQueues extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('public.queue-board');
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

    public function shownext(){
        try {

            $queue = QueueCall::orderBy('id','desc')->where('is_called',false)->first();
            $data = [];
            if($queue){
                $queue->is_called = true;
                $queue->update();

                $data = [
                    'queue_number' => $queue->checklist->queue->queue_number,
                    'transaction' => $queue->checklist->station->name,
                ];
            }
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch queues',
                'error' => $e->getMessage()
            ], 500);
        }

    }
    public function showqueues(){

        try {
            $stations = QueueChecklist::current()
                ->select('station_id')
                ->with('station')
                ->distinct()
                ->get();
            $queues = [];
            foreach($stations as $station){
                // $checklists = QueueChecklist::where('station_id',  1)
                $checklists = QueueChecklist::where('station_id',  $station->station_id)
                    ->applySorting()
                    ->today()
                    ->current();
                    // dd($checklists->get());
                $now_serving = (clone $checklists)->processing()->first();
                if(!$now_serving){
                    $now_serving = [];
                }else{
                    $now_serving = [
                        'number' => $now_serving->queue->queue_number,
                        'name' => $now_serving->queue->patient?->first_name ?? 'Guest',
                    ];
                }
                $next_in_line = (clone $checklists)
                    ->pending()
                    ->limit(12)
                    ->get()->map(function($map){
                        return [
                            'number' => $map->queue->queue_number,
                            'name' => $map->queue->patient?->first_name ?? 'Guest',
                        ];
                    });
                $queues[] = collect([
                    'station' => $station->station->name,
                    'now_serving' => $now_serving,
                    'next_in_line' => $next_in_line,
                ]);
            }

            return response()->json([
                'status' => 'success',
                'data' => $queues
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch queues',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
