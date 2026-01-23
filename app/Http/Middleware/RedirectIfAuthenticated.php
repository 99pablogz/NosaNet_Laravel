<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next)
    {
        if (Session::has('username')) {
            return redirect()->route('home')
                ->with('info', 'Ya tienes una sesión iniciada');
        }
        
        return $next($request);
    }
}