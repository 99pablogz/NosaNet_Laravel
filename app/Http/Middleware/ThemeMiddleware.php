<?php
// app/Http/Middleware/ThemeMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class ThemeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Primero, intentar obtener el tema de la sesión
        if (Session::has('theme')) {
            $theme = Session::get('theme');
        } 
        // Si no hay en sesión, buscar en cookies
        elseif ($request->hasCookie('theme')) {
            $theme = $request->cookie('theme');
            Session::put('theme', $theme);
        }
        // Si el usuario está autenticado, cargar su tema de la base de datos
        elseif (Session::has('username')) {
            $username = Session::get('username');
            $user = User::findByUsername($username);
            
            if ($user && isset($user['theme'])) {
                $theme = $user['theme'];
                Session::put('theme', $theme);
                
                // Establecer cookie para recordar
                Cookie::queue('theme', $theme, 30 * 24 * 60);
            } else {
                $theme = 'light';
            }
        }
        // Por defecto, tema claro
        else {
            $theme = 'light';
        }
        
        // Compartir el tema con todas las vistas
        view()->share('theme', $theme);
        
        return $next($request);
    }
}