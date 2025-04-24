<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;

Route::get('/', function () {
    return redirect()->route('guest.create');
});

// Buku Tamu
Route::get('/buku-tamu', [GuestController::class, 'create'])->name('guest.create');
Route::post('/buku-tamu', [GuestController::class, 'store'])->name('guest.store');

// Data Rumah Sakit
Route::post('/guestbook', [GuestController::class, 'store'])->name('guestbook.store');

Route::get('/data-rumah-sakit', [GuestController::class, 'index'])->name('hospitals.index');
Route::get('/get-cities', [GuestController::class, 'getCities'])->name('hospitals.cities');
Route::get('/get-hospitals', [GuestController::class, 'getHospitals'])->name('hospitals.getHospitals');
Route::get('/search-hospitals', [GuestController::class, 'searchHospitals'])->name('hospitals.searchHospitals');

