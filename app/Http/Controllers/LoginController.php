<?php
// app/Http/Controllers/LoginController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        
        $user = User::findByUsername($request->username);
        
        if (!$user) {
            return redirect()->back()
                ->withErrors(['username' => 'Usuario no encontrado'])
                ->withInput();
        }
        
        if (!Hash::check($request->password, $user['password'])) {
            return redirect()->back()
                ->withErrors(['password' => 'Contraseña incorrecta'])
                ->withInput();
        }
        
        // Guardar en sesión
        Session::put('user_id', $user['id']);
        Session::put('username', $user['username']);
        Session::put('email', $user['email']);
        Session::put('is_professor', $user['isProfessor']);
        Session::put('theme', $user['theme'] ?? 'light');
        
        // Regenerar ID de sesión por seguridad
        Session::regenerate();
        
        return redirect()->route('home')
            ->with('success', 'Bienvenido ' . $user['username']);
    }
    
    public function logout(Request $request)
    {
        // Limpiar toda la sesión
        Session::flush();
        
        // Invalidar la sesión
        Session::invalidate();
        
        // Regenerar token CSRF
        $request->session()->regenerateToken();
        
        return redirect()->route('home')
            ->with('success', 'Sesión cerrada correctamente');
    }
}