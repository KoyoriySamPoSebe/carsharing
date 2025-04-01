<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\VehicleController;
use App\Livewire\AdminDashboard;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:super-admin|admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::resource('vehicles', VehicleController::class);
    Route::get('/rents', [RentController::class, 'index'])->name('rents.index');
});


Route::get('/admin', AdminDashboard::class);

require __DIR__ . '/auth.php';
