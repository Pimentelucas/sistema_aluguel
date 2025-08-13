<?php

use App\Http\Controllers\EquipamentController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Models\Equipament;
use App\Models\EquipamentAvailability;
use Illuminate\Support\Facades\Auth;



Route::get('/', [EquipamentController::class, 'index']);
Route::get('/equipaments/create', [EquipamentController::class, 'create'])->middleware('auth');
Route::post('/equipaments', [EquipamentController::class, 'store']);
Route::get('/equipaments/{id}', [EquipamentController::class, 'show']);
Route::delete('/equipaments/{id}', [EquipamentController::class, 'destroy'])->middleware('auth');
Route::get('/equipaments/edit/{id}', [EquipamentController::class, 'edit'])->middleware('auth');
Route::put('/equipaments/update/{id}', [EquipamentController::class, 'update'])->middleware('auth');
Route::post('/equipaments/reserve', [EquipamentController::class, 'reserve'])->name('equipaments.reserve');
Route::get('/equipaments/{id}/reservations', [EquipamentController::class, 'getReservations']);
Route::resource('equipaments', EquipamentController::class)->middleware('auth');
Route::get('/dashboard', function () {
    $userId = Auth::id();
    $createdEquipaments = Equipament::where('user_id', $userId)->get();
    $rentedEquipamentIds = EquipamentAvailability::where('user_id', $userId)
        ->pluck('equipament_id')
        ->unique()
        ->toArray();

    $rentedEquipaments = Equipament::whereIn('id', $rentedEquipamentIds)->get();

    return view('equipaments.dashboard', [
        'createdEquipaments' => $createdEquipaments,
        'rentedEquipaments'  => $rentedEquipaments,
    ]);
})->middleware(['auth'])->name('dashboard');

