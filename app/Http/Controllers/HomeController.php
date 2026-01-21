<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    //index muestra la página de inicio con los mensajes aprobados ordenados por timestamp descendente
    public function index()
    {
        // Asegurar que $messages sea una colección
        $messages = Message::getApproved();
        
        // Si getApproved() retorna un array, conviértelo a colección
        if (is_array($messages)) {
            $messages = collect($messages);
        }
        
        // Ordenar por timestamp descendente
        $messages = $messages->sortByDesc('timestamp');
        
        return view('home', compact('messages'));
    }
}