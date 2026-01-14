<?php
// app/Http\Controllers/ModerationController.php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ModerationController extends Controller  // Asegúrate de extender Controller
{
    // NO uses middleware() en el constructor, usa el middleware en las rutas
    
    public function index()
    {
        // Verificar si es profesor directamente en el método
        if (!Session::has('is_professor') || Session::get('is_professor') !== 'True') {
            return redirect()->route('home')
                ->with('error', 'No tienes permisos de moderación');
        }
        
        $pendingMessages = Message::getPending();
        
        // Si getPending() retorna un array, convertirlo a array
        if (is_array($pendingMessages)) {
            // Ya es un array
        } elseif (method_exists($pendingMessages, 'all')) {
            // Si es una colección, convertir a array
            $pendingMessages = $pendingMessages->all();
        } else {
            $pendingMessages = [];
        }
        
        // Ordenar por timestamp descendente
        usort($pendingMessages, function($a, $b) {
            return strtotime(str_replace('/', '-', $b['timestamp'])) - 
                   strtotime(str_replace('/', '-', $a['timestamp']));
        });
        
        return view('moderation', compact('pendingMessages'));
    }
    
    public function approve(Request $request)
    {
        // Verificar si es profesor
        if (!Session::has('is_professor') || Session::get('is_professor') !== 'True') {
            return redirect()->route('home')
                ->with('error', 'No tienes permisos de moderación');
        }
        
        $messageId = $request->message_id;
        
        if (!$messageId) {
            return redirect()->route('moderation.index')
                ->with('error', 'ID de mensaje no proporcionado');
        }
        
        $updated = Message::update($messageId, [
            'approved' => 'true',
            'moderated_at' => date('H:i d/m/Y'),
            'moderated_by' => Session::get('username')
        ]);
        
        if ($updated) {
            return redirect()->route('moderation.index')
                ->with('success', 'Mensaje aprobado correctamente');
        } else {
            return redirect()->route('moderation.index')
                ->with('error', 'No se pudo encontrar el mensaje');
        }
    }
    
    public function delete(Request $request)
    {
        // Verificar si es profesor
        if (!Session::has('is_professor') || Session::get('is_professor') !== 'True') {
            return redirect()->route('home')
                ->with('error', 'No tienes permisos de moderación');
        }
        
        $request->validate([
            'message_id' => 'required',
            'delete_reason' => 'required|min:3'
        ]);
        
        $updated = Message::update($request->message_id, [
            'status' => 'deleted',
            'delete_reason' => htmlspecialchars($request->delete_reason),
            'deleted_at' => date('H:i d/m/Y'),
            'deleted_by' => Session::get('username')
        ]);
        
        if ($updated) {
            return redirect()->route('moderation.index')
                ->with('success', 'Mensaje eliminado correctamente');
        } else {
            return redirect()->route('moderation.index')
                ->with('error', 'No se pudo encontrar el mensaje');
        }
    }
}