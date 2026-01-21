<?php
// app/Http/Controllers/ThemeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class ThemeController extends Controller
{
    public function toggle(Request $request)
    {
        $currentTheme = Session::get('theme', 'light');
        $newTheme = $currentTheme === 'light' ? 'dark' : 'light';
        
        // Guardar en sesión
        Session::put('theme', $newTheme);
        
        // Guardar en base de datos si el usuario está autenticado
        if (auth_check()) {
            $username = Session::get('username');
            $user = User::findByUsername($username);
            
            if ($user) {
                // Actualizar el tema del usuario
                User::update($user['id'], ['theme' => $newTheme]);
            }
        }
        
        // Crear cookie que dura 30 días
        $cookie = Cookie::make('theme', $newTheme, 30 * 24 * 60);
        
        return redirect()->back()->withCookie($cookie);
    }
}