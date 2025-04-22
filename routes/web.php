<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;

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
    return view('/create');
});


Route::get('/buku-tamu', [GuestController::class, 'create'])->name('create');
Route::post('/buku-tamu', [GuestController::class, 'store'])->name('guestbook.store');

Route::get('/data', [GuestController::class, 'data'])->name('data');
Route::get('/data-rumahsakit', [GuestController::class, 'extractHospitals'])->name('data.rumahsakit');


Route::get('/baca-pdf', [GuestController::class, 'bacaDataPDF'])->name('guest.bacaPDF');
