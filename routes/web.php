<?php

use App\Http\Controllers\AdminComentarioController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IdosoController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('public.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::post('/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');

    Route::get('/admin/comentarios', [AdminComentarioController::class, 'index'])
        ->middleware('admin')
        ->name('admin.comentarios.index');

    Route::patch('/admin/comentarios/{comentario}/aprovar', [AdminComentarioController::class, 'aprovar'])
        ->middleware('admin')
        ->name('admin.comentarios.aprovar');

    Route::patch('/admin/comentarios/{comentario}/rejeitar', [AdminComentarioController::class, 'rejeitar'])
        ->middleware('admin')
        ->name('admin.comentarios.rejeitar');

    Route::delete('/admin/comentarios/{comentario}', [AdminComentarioController::class, 'destroy'])
        ->middleware('admin')
        ->name('admin.comentarios.destroy');

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::prefix('idosos')->group(function () {
        Route::get('/cadastrar', [IdosoController::class, 'escolherCadastro'])->name('idosos.cadastrar');
        Route::get('/vincular', [IdosoController::class, 'vincularForm'])->name('idosos.vincular');
        Route::post('/vincular', [IdosoController::class, 'vincular'])->name('idosos.vincular.store');
        Route::get('/gerenciar', [IdosoController::class, 'gerenciar'])->name('idosos.gerenciar');

        Route::prefix('create')->group(function () {
            Route::get('/step1', [IdosoController::class, 'createStep1'])->name('idosos.create.step1');
            Route::post('/step1', [IdosoController::class, 'storeStep1'])->name('idosos.store.step1');

            Route::get('/{idoso}/step2', [IdosoController::class, 'createStep2'])->name('idosos.create.step2');
            Route::post('/{idoso}/step2', [IdosoController::class, 'storeStep2'])->name('idosos.store.step2');

            Route::get('/{idoso}/step3', [IdosoController::class, 'createStep3'])->name('idosos.create.step3');
            Route::post('/{idoso}/step3', [IdosoController::class, 'storeStep3'])->name('idosos.store.step3');

            Route::get('/{idoso}/step4', [IdosoController::class, 'createStep4'])->name('idosos.create.step4');
            Route::post('/{idoso}/step4', [IdosoController::class, 'storeStep4'])->name('idosos.store.step4');
        });

        Route::delete('/{idoso}/contatos/{contato}', [IdosoController::class, 'removerContato'])
            ->name('idosos.contatos.destroy');

        Route::get('/{idoso}', [IdosoController::class, 'show'])->name('idosos.show');
        Route::get('/{idoso}/editar', [IdosoController::class, 'edit'])->name('idosos.edit');
        Route::put('/{idoso}', [IdosoController::class, 'update'])->name('idosos.update');
        Route::delete('/{idoso}/desvincular', [IdosoController::class, 'desvincular'])->name('idosos.desvincular');

        Route::prefix('{idoso}')->group(function () {
            Route::put('/update-step1', [IdosoController::class, 'updateStep1'])->name('idosos.update.step1');
            Route::put('/update-step2', [IdosoController::class, 'updateStep2'])->name('idosos.update.step2');
            Route::put('/update-step3', [IdosoController::class, 'updateStep3'])->name('idosos.update.step3');
            Route::put('/update-step4', [IdosoController::class, 'updateStep4'])->name('idosos.update.step4');
        });

        Route::prefix('{idoso}/medicamentos')->group(function () {
            Route::get('/', [MedicamentoController::class, 'index'])->name('medicamentos.index');
            Route::get('/criar', [MedicamentoController::class, 'create'])->name('medicamentos.create');
            Route::post('/', [MedicamentoController::class, 'store'])->name('medicamentos.store');
            Route::get('/{medicamento}/editar', [MedicamentoController::class, 'edit'])->name('medicamentos.edit');
            Route::put('/{medicamento}', [MedicamentoController::class, 'update'])->name('medicamentos.update');
            Route::delete('/{medicamento}', [MedicamentoController::class, 'destroy'])->name('medicamentos.destroy');
            Route::patch('/{medicamento}/toggle-tomado', [MedicamentoController::class, 'toggleTomado'])->name('medicamentos.toggleTomado');
        });

        Route::prefix('{idoso}/eventos')->group(function () {
            Route::get('/', [EventoController::class, 'index'])->name('eventos.index');
            Route::get('/criar', [EventoController::class, 'create'])->name('eventos.create');
            Route::post('/', [EventoController::class, 'store'])->name('eventos.store');
            Route::get('/{evento}/editar', [EventoController::class, 'edit'])->name('eventos.edit');
            Route::put('/{evento}', [EventoController::class, 'update'])->name('eventos.update');
            Route::delete('/{evento}', [EventoController::class, 'destroy'])->name('eventos.destroy');
            Route::patch('/{evento}/toggle-resolvido', [EventoController::class, 'toggleResolvido'])->name('eventos.toggleResolvido');
        });

        Route::get('/{idoso}/contatos', [ContatoController::class, 'index'])->name('contatos.index');
    });

    Route::middleware('admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

            Route::prefix('users')->group(function () {
                Route::get('/', [AdminController::class, 'users'])->name('users');
                Route::get('/create', [AdminController::class, 'createUser'])->name('users.create');
                Route::post('/', [AdminController::class, 'storeUser'])->name('users.store');
                Route::delete('/bulk', [AdminController::class, 'destroyUsersBulk'])->name('users.destroyBulk');
                Route::delete('/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
                Route::patch('/{id}/restore', [AdminController::class, 'restoreUser'])->name('users.restore');
                Route::delete('/{id}/force', [AdminController::class, 'forceDeleteUser'])->name('users.forceDelete');
            });

            Route::prefix('idosos')->group(function () {
                Route::get('/', [AdminController::class, 'idosos'])->name('idosos');
                Route::get('/create', [AdminController::class, 'createIdoso'])->name('idosos.create');
                Route::post('/', [AdminController::class, 'storeIdoso'])->name('idosos.store');
                Route::delete('/bulk', [AdminController::class, 'destroyIdososBulk'])->name('idosos.destroyBulk');
                Route::delete('/{idoso}', [AdminController::class, 'destroyIdoso'])->name('idosos.destroy');
                Route::patch('/{id}/restore', [AdminController::class, 'restoreIdoso'])->name('idosos.restore');
                Route::delete('/{id}/force', [AdminController::class, 'forceDeleteIdoso'])->name('idosos.forceDelete');
                Route::post('/{idoso}/vincular-admin', [IdosoController::class, 'vincularAdmin'])->name('idosos.vincularAdmin');
            });
        });
});

require __DIR__ . '/auth.php';