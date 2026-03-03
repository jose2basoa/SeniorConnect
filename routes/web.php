<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IdosoController;

Route::get('/', function () {
    return view('public.index');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // WIZARD IDOSO
    Route::prefix('idosos')->group(function () {

        Route::get('/create/step1', [IdosoController::class, 'createStep1'])
            ->name('idosos.create.step1');

        Route::post('/create/step1', [IdosoController::class, 'storeStep1'])
            ->name('idosos.store.step1');

        Route::get('/{idoso}/create/step2', [IdosoController::class, 'createStep2'])
            ->name('idosos.create.step2');

        Route::post('/{idoso}/create/step2', [IdosoController::class, 'storeStep2'])
            ->name('idosos.store.step2');

        Route::get('/{idoso}/create/step3', [IdosoController::class, 'createStep3'])
            ->name('idosos.create.step3');

        Route::post('/{idoso}/create/step3', [IdosoController::class, 'storeStep3'])
            ->name('idosos.store.step3');

        Route::get('/{idoso}/create/step4', [IdosoController::class, 'createStep4'])
            ->name('idosos.create.step4');

        Route::post('/{idoso}/create/step4', [IdosoController::class, 'storeStep4'])
            ->name('idosos.store.step4');
    });

});

require __DIR__.'/auth.php';