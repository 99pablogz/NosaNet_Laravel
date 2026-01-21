<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ModerationController;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Collection;

// Aplicar el middleware de tema a todas las rutas
Route::middleware(['theme'])->group(function () {
    
    // Autenticación
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/messages/new', function () {
        // Cargar mensajes aprobados
        $messages = \App\Models\Message::getApproved();
        
        // Forzar que sea una colección si no lo es
        if (!($messages instanceof Collection)) {
            if (is_array($messages)) {
                $messages = collect($messages);
            } else {
                $messages = collect([]);
            }
        }
        
        // Ordenar por timestamp descendente
        $messages = $messages->sortByDesc('timestamp');
        
        return view('home', compact('messages'));
    })->name('home');
    
    // Tema
    Route::post('/theme/toggle', [ThemeController::class, 'toggle'])->name('theme.toggle');

    // Mensajes
    Route::middleware(['auth.custom'])->group(function () {
        Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
        Route::get('/messages/my-messages', [MessageController::class, 'myMessages'])->name('messages.my');
    });

    // Moderación
    Route::middleware(['auth.custom', 'professor'])->group(function () {

    Route::post('/moderation/approve', [ModerationController::class, 'approve'])->name('moderation.approve');
        Route::post('/moderation/delete', [ModerationController::class, 'delete'])->name('moderation.delete');
    });
    
    // Página principal
    Route::get('/', function () {
        // Cargar mensajes aprobados
        $messages = \App\Models\Message::getApproved();
        
        // Forzar que sea una colección si no lo es
        if (!($messages instanceof Collection)) {
            if (is_array($messages)) {
                $messages = collect($messages);
            } else {
                $messages = collect([]);
            }
        }
        
        // Ordenar por timestamp descendente
        $messages = $messages->sortByDesc('timestamp');
        
        return view('home', compact('messages'));
    })->name('home');
});