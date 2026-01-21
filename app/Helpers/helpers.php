<?php
// app/Helpers/helpers.php
//helpers funciona para gestionar la autenticación y la información del usuario en sesión
//uso de la clase Session de Laravel
use Illuminate\Support\Facades\Session;

//si la función auth_check no existe, se define
if (!function_exists('auth_check')) {
    //auth_check verifica si el usuario está autenticado comprobando si la sesión tiene un nombre de usuario válido
    function auth_check()
    {
        return Session::has('username') && !empty(Session::get('username'));
    }
}

//si la función is_professor no existe, se define
if (!function_exists('is_professor')) {
    //is_professor verifica si el usuario autenticado tiene el rol de profesor comprobando un valor en la sesión
    function is_professor()
    {
        return Session::has('is_professor') && Session::get('is_professor') === 'True';
    }
}
//
if (!function_exists('current_user')) {
    //current_user devuelve un array con la información del usuario autenticado obtenida de la sesión
    function current_user()
    {
        return [
            'id' => Session::get('user_id'),
            'username' => Session::get('username'),
            'email' => Session::get('email'),
            'is_professor' => Session::get('is_professor'),
            'theme' => Session::get('theme', 'light')
        ];
    }
}