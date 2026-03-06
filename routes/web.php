<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IdosoController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\ContatoController;

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

    // Perfil do usuário logado
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Idosos
    |--------------------------------------------------------------------------
    */
    Route::prefix('idosos')->group(function () {

        // Fluxo inicial (escolher cadastrar ou vincular)
        Route::get('/cadastrar', [IdosoController::class, 'escolherCadastro'])->name('idosos.cadastrar');

        // Vincular existente
        Route::get('/vincular', [IdosoController::class, 'vincularForm'])->name('idosos.vincular');
        Route::post('/vincular', [IdosoController::class, 'vincular'])->name('idosos.vincular.buscar');

        // Gerenciar (lista)
        Route::get('/gerenciar', [IdosoController::class, 'gerenciar'])->name('idosos.gerenciar');

        // Medicamentos
        Route::get('/{idoso}/medicamentos', [MedicamentoController::class, 'index'])->name('medicamentos.index');

        // Eventos
        Route::get('/{idoso}/eventos', [EventoController::class, 'index'])->name('eventos.index');

        // Contatos (tutores + emergência)
        Route::get('/{idoso}/contatos', [ContatoController::class, 'index'])->name('contatos.index');

        /*
        |--------------------------------------------------------------------------
        | Wizard de cadastro (steps)
        | IMPORTANTE: deixe antes das rotas dinâmicas /{idoso}
        |--------------------------------------------------------------------------
        */
        Route::get('/create/step1', [IdosoController::class, 'createStep1'])->name('idosos.create.step1');
        Route::post('/create/step1', [IdosoController::class, 'storeStep1'])->name('idosos.store.step1');

        Route::get('/{idoso}/create/step2', [IdosoController::class, 'createStep2'])->name('idosos.create.step2');
        Route::post('/{idoso}/create/step2', [IdosoController::class, 'storeStep2'])->name('idosos.store.step2');

        Route::get('/{idoso}/create/step3', [IdosoController::class, 'createStep3'])->name('idosos.create.step3');
        Route::post('/{idoso}/create/step3', [IdosoController::class, 'storeStep3'])->name('idosos.store.step3');

        Route::get('/{idoso}/create/step4', [IdosoController::class, 'createStep4'])->name('idosos.create.step4');
        Route::post('/{idoso}/create/step4', [IdosoController::class, 'storeStep4'])->name('idosos.store.step4');

        // Remover contato (wizard / edição)
        Route::delete('/{idoso}/contato/{contato}', [IdosoController::class, 'removerContato'])->name('idosos.contato.remover');

        /*
        |--------------------------------------------------------------------------
        | Perfil + edição completa (tela única)
        |--------------------------------------------------------------------------
        */
        Route::get('/{idoso}', [IdosoController::class, 'show'])->name('idosos.show');
        Route::get('/{idoso}/editar', [IdosoController::class, 'edit'])->name('idosos.edit');

        // Updates separados por card (para sua tela com 4 seções)
        Route::put('/{idoso}/update-step1', [IdosoController::class, 'updateStep1'])->name('idosos.update.step1');
        Route::put('/{idoso}/update-step2', [IdosoController::class, 'updateStep2'])->name('idosos.update.step2');
        Route::put('/{idoso}/update-step3', [IdosoController::class, 'updateStep3'])->name('idosos.update.step3');
        Route::put('/{idoso}/update-step4', [IdosoController::class, 'updateStep4'])->name('idosos.update.step4');

        // (Opcional) manter update geral
        Route::put('/{idoso}', [IdosoController::class, 'update'])->name('idosos.update');

        // Desvincular
        Route::delete('/{idoso}/desvincular', [IdosoController::class, 'desvincular'])->name('idosos.desvincular');
    });
});

/*
|--------------------------------------------------------------------------
| Rotas Admin (Somente Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('admin.dashboard');

        // USERS
        Route::get('/users', [AdminController::class, 'users'])
            ->name('admin.users');

        Route::delete('/users/bulk', [AdminController::class, 'destroyUsersBulk'])
            ->name('admin.users.destroyBulk');

        // IDOSOS
        Route::get('/idosos', [AdminController::class, 'idosos'])
            ->name('admin.idosos');

        Route::delete('/idosos/bulk', [AdminController::class, 'destroyIdososBulk'])
            ->name('admin.idosos.destroyBulk');

        // USERS (criar)
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');

        // IDOSOS (criar somente step 1)
        Route::get('/idosos/create', [AdminController::class, 'createIdoso'])->name('admin.idosos.create');
        Route::post('/idosos', [AdminController::class, 'storeIdoso'])->name('admin.idosos.store');

        Route::post('/idosos/{idoso}/vincular-admin', [IdosoController::class, 'vincularAdmin'])
            ->name('idosos.vincular.admin');
    });

require __DIR__ . '/auth.php';
