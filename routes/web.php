<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IdosoController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Página Pública
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('public.index');
})->name('public.index');


/*
|--------------------------------------------------------------------------
| Dashboard do Usuário
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| Rotas Autenticadas (Usuário comum)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | Wizard Idoso
    |--------------------------------------------------------------------------
    */

    Route::prefix('idosos')->group(function () {

        Route::get('/cadastrar', [IdosoController::class, 'escolherCadastro'])
            ->name('idosos.cadastrar');

        Route::get('/idosos/vincular', [IdosoController::class, 'vincularForm'])
            ->name('idosos.vincular');

        Route::post('/idosos/vincular', [IdosoController::class, 'vincular'])
            ->name('idosos.vincular.buscar');

        Route::get('/gerenciar', [IdosoController::class, 'gerenciar'])
            ->name('idosos.gerenciar');

        Route::delete('/{idoso}/desvincular', [IdosoController::class, 'desvincular'])
            ->name('idosos.desvincular');

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

        Route::delete('/{idoso}/contato/{contato}', [IdosoController::class, 'removerContato'])
            ->name('idosos.contato.remover');

    });

});


/*
|--------------------------------------------------------------------------
| ROTAS ADMIN (Somente Admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('admin.dashboard');

        Route::get('/users', [AdminController::class, 'users'])
            ->name('admin.users');

        Route::get('/idosos', [AdminController::class, 'idosos'])
            ->name('admin.idosos');

    });


require __DIR__.'/auth.php';
