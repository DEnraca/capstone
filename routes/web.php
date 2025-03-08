<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;

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
    return view('welcome');
});


Route::get('/search-results', function () {
    return view('search');
});

Route::post('/view-results', [PDFController::class, 'viewResults']);


Route::get('/pdf/generate/hematology/{employee_id}', [PDFController::class, 'generateHematologyPDF']);
Route::get('/pdf/generate/masterlist/{masterlist_id}', [PDFController::class, 'generateAPEForms']);
Route::get('/pdf/generate/radiograph/{employee_id}', [PDFController::class, 'generateRadiologyPDF']);
Route::get('/pdf/generate/bloodchem/{employee_id}', [PDFController::class, 'generateBloodPDF']);





Route::get('/export/availment/{masterlist_id}', [PDFController::class, 'generateAvailmentReport'])->name('availment.export');

Route::get('/export/summary/{masterlist_id}', [PDFController::class, 'generateSummaryReport'])->name('summary.export');
Route::get('/export/lab/{masterlist_id}', [PDFController::class, 'generateLabReport'])->name('lab.export');


Route::get('/pdf/generate/serology/{employee_id}', [PDFController::class, 'generateSerologyPDF']);
Route::get('/pdf/preview/{employee_id}', [PDFController::class, 'generatePreviewPDF'])->name('pdf.preview');
Route::get('/pdf/generate/masterlist/{masterlist_id}', [PDFController::class, 'generateExportForms'])->name('masterlist.export');
