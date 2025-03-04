<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seguridad\LoginController;
use App\Http\Controllers\Seguridad\PasswordResetController;
use App\Http\Controllers\Seguridad\UsuarioController;

Route::get('/', function () {
    return redirect('/seguridad/auth/login');
});

/**SEGURIDAD */
Route::prefix('seguridad')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('/login', [
            LoginController::class, 'login'
        ])->name('login');

        Route::post('/acceso', [
            LoginController::class,
            'acceso'
        ])->name('login.acceso');
    });
    
    /**USUARIO */
    Route::prefix('usuario')->group(function () {
        Route::get('/catalogo', [
            UsuarioController::class,
            'catalogo'
        ])->name('usuarios.catalogo');

        Route::get('/{id}/detalle', [
            UsuarioController::class, 
            'detalle'
            ])->name('usuarios.detalle');
        
        Route::post('/{id}/adjuntarFoto', [
                UsuarioController::class,
                'adjuntarFoto'
            ])->name('usuarios.adjuntarFoto');
        
        Route::get('/{id}/adjuntarFoto', [
                UsuarioController::class,
                'adjuntarFotoForm'
            ])->name('usuarios.adjuntarFotoForm');

    }); 


    Route::prefix('password')->group(function () {
        Route::get('/email', [PasswordResetController::class, 'showEmailForm'])->name('password.email');
        Route::post('/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
        

        Route::get('/token', [PasswordResetController::class, 'showTokenForm'])->name('password.token.form');
        Route::post('/token', [PasswordResetController::class, 'verifyToken'])->name('password.token.verify');
        
        Route::get('/reset', [PasswordResetController::class, 'showUpdatePass'])->name('password.update.form');
        Route::post('/reset', [PasswordResetController::class, 'reset'])->name('password.update');
    });
});
