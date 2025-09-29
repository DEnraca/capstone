<?php

use App\Http\Controllers\ShowQueues;
use App\Livewire\CreateApointment;
use Illuminate\Support\Facades\Route;
use App\Livewire\Queues;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('public.welcome');
})->name('home');


Route::get('/admin/queue-board', [ShowQueues::class,'index']);
Route::get('/my-component', function () {
    return view('public.create-appointment');
})->name('livewire-appointment');

Route::get('/search-results', function () {
    return view('search');
});

Route::get('/queues', Queues::class);



