<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

//uso las clases necesarias
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

//
class AuthController extends Controller
{
    //showregister muestra la vista de registro
    public function showRegister()
    {
        return view('auth.register');
    }
    //esta funcion register maneja el registro de un nuevo usuario
    public function register(Request $request)
    {
        //uso validator para validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'username' => 'required|regex:/^[A-Za-z0-9._-]{1,24}$/',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'isProfessor' => 'sometimes|in:True,False'
        ], [
            'username.regex' => 'Nombre de usuario inválido. Solo puede contener letras, numeros y los símbolos \'_\', \'-\' y \'.\'.'
        ]);
        //si la validación falla, redirijo de vuelta con errores y datos antiguos
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Verificar si el usuario ya existe
        if (User::findByUsername($request->username)) {
            return redirect()->back()
                ->withErrors(['username' => 'Nombre de usuario en uso'])
                ->withInput();
        }
        //si el correo ya está en uso, redirijo de vuelta con error
        if (User::findByEmail($request->email)) {
            return redirect()->back()
                ->withErrors(['email' => 'Correo electrónico en uso'])
                ->withInput();
        }

        // Crear usuario con user model y guardar en la base de datos usando user model que usa Eloquent
        $user = User::create([
            'id' => uniqid(),
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'isProfessor' => $request->isProfessor ?? 'False',
            'theme' => 'light'
        ]);
        //redirige a la página de login con mensaje de éxito
        return redirect()->route('login')
            ->with('success', 'Registro exitoso. Ya puedes iniciar sesión.');
    }
}