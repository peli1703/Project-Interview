<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\ResponseController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/', [InterviewController::class, 'landing'])->name('home');
Route::get('/login', [InterviewController::class, 'login'])->name('login');
Route::post('/kirim-data',[InterviewController::class, 'store'])->name('kirim_data');
Route::post('/auth', [InterviewController::class, 'auth'])->name('auth');

Route::middleware('IsLogin','CekRole:admin')->group(function() {
    Route::get('/dashadmin', [InterviewController::class, 'index'])->name('dashadmin');
    Route::delete('/hapus/{id}', [InterviewController::class, 'destroy'])->name('delete');
    Route::get('/export/pdf', [InterviewController::class, 'exportPDF'])->name('export.pdf');
    Route::get('/export/excel', [InterviewController::class, 'exportExcel'])->name('export.excel');

});

Route::middleware('IsLogin','CekRole:petugas')->group(function() {
    Route::get('/data/petugas', [InterviewController::class, 'dataPetugas'])->name('data.petugas');
    Route::get('/response/edit/{report_id}',[ResponseController::class, 'edit'])->name('response.edit');
    // kirim data-response,menggunakan patch karena dia bisa berupa tambah data atau update data 8
    Route::patch('/response/update/{report_id}',[ResponseController::class, 'update'])->name('response.update');
});

Route::middleware('IsLogin','CekRole:admin,petugas')->group(function() {
    Route::get('/logout', [InterviewController::class, 'logout'])->name('logout');
});



