<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    Route::get('vehicles', [\App\Http\Controllers\MyCars\VehiclesController::class, 'index'])
        ->name('vehicles');
    Route::get('vehicles/new', [\App\Http\Controllers\MyCars\VehiclesController::class, 'showCreate'])
        ->name('vehicles-new');
    Route::get('/vehicles/{id}', [\App\Http\Controllers\MyCars\VehiclesController::class, 'detail'])->name('vehicles.show');
    Route::delete('/vehicles/{id}', [\App\Http\Controllers\MyCars\VehiclesController::class, 'destroy'])->name('vehicles.destroy');
    Route::post('vehicles', [\App\Http\Controllers\MyCars\VehiclesController::class, 'store']);

    Route::get('events', [\App\Http\Controllers\Events\EventsController::class, 'index'])
        ->name('events.show');
    Route::get('events/create', [\App\Http\Controllers\Events\EventsController::class, 'store'])
        ->name('events.create');
});



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
