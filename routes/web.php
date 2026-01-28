<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ModerationController;
use App\Http\Controllers\ThemeController;

// Aplicar el middleware de tema a todas las rutas
Route::middleware(['theme'])->group(function () {
    
    // Página principal y nuevo mensaje (GET)
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/messages/new', [HomeController::class, 'index'])->name('messages.new');
    
    // Autenticación (solo para invitados)
    Route::middleware(['guest'])->group(function () {
        Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [AuthController::class, 'register']);
        Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);
    });
    
    // Logout (solo para autenticados)
    Route::post('/logout', [LoginController::class, 'logout'])
        ->middleware(['auth.custom'])
        ->name('logout');
    
    // Tema 
    Route::post('/theme', [ThemeController::class, 'toggle'])->name('theme.toggle');
    
    // Mensajes (solo para autenticados)
    Route::middleware(['auth.custom'])->group(function () {
        Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
        Route::get('/messages/my-messages', [MessageController::class, 'myMessages'])->name('messages.my');
    });

    // Moderación (solo para profesores autenticados)
    Route::middleware(['auth.custom', 'professor'])->group(function () {
         Route::get('/moderation', [ModerationController::class, 'index'])->name('moderation.index');
    Route::post('/moderation/{id}/approve', [ModerationController::class, 'approve'])->name('moderation.approve');
    Route::post('/moderation/{id}/delete', [ModerationController::class, 'delete'])->name('moderation.delete');
    });
});