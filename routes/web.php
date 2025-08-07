<?php

use App\Http\Controllers\EquipamentController;
use Illuminate\Support\Facades\Route;


Route::get('/', [EquipamentController::class, 'index']);
Route::get('/equipaments/create', [EquipamentController::class, 'create'])->middleware('auth');
Route::post('/equipaments', [EquipamentController::class, 'store']);
Route::get('/equipaments/{id}', [EquipamentController::class, 'show']);
Route::delete('/equipaments/{id}', [EquipamentController::class, 'destroy'])->middleware('auth');
Route::get('/equipaments/edit/{id}', [EquipamentController::class, 'edit'])->middleware('auth');
Route::put('/equipaments/update/{id}', [EquipamentController::class, 'update'])->middleware('auth');
Route::post('/equipaments/reserve', [EquipamentController::class, 'reserve'])->name('equipaments.reserve');
Route::get('/equipaments/{id}/reservations', [EquipamentController::class, 'getReservations']);


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
