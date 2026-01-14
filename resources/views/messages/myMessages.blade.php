{{-- resources/views/messages/myMessages.blade.php --}}
@extends('layouts.app')

@section('title', 'Mis Posts - NosaNet')

@section('content')
<div class="tabs-container">
    <h1>Mis Posts</h1>
    
    <div class="tabs">
        <button class="tab active" onclick="showTab('aprobados')">
            Aprobados <span class="posts-count">{{ count($approvedMessages) }}</span>
        </button>
        <button class="tab" onclick="showTab('pendientes')">
            Pendientes <span class="posts-count">{{ count($pendingMessages) }}</span>
        </button>
        <button class="tab" onclick="showTab('eliminados')">
            Eliminados <span class="posts-count">{{ count($deletedMessages) }}</span>
        </button>
    </div>
    
    <!-- Tab Aprobados -->
    <div id="aprobados" class="tab-content active">
        <h2>Mensajes Aprobados</h2>
        @if(empty($approvedMessages))
            <div class="empty-state">
                <h3>No tienes mensajes aprobados</h3>
                <p>Los mensajes que sean aprobados por los moderadores aparecerán aquí.</p>
            </div>
        @else
            @foreach($approvedMessages as $message)
                <div class="message-card">
                    <div class="message-header">
                        <span class="message-user">{{ $message['user'] ?? 'Usuario' }}</span>
                        <span class="message-time">{{ $message['timestamp'] ?? 'Sin fecha' }}</span>
                    </div>
                    <div class="message-title">{{ $message['title'] ?? 'Sin título' }}</div>
                    <div class="message-text">{{ $message['text'] ?? 'Sin contenido' }}</div>
                    <span class="message-status status-approved">Aprobado</span>
                </div>
            @endforeach
        @endif
    </div>
    
    <!-- Tab Pendientes -->
    <div id="pendientes" class="tab-content">
        <h2>Mensajes Pendientes de Moderación</h2>
        @if(empty($pendingMessages))
            <div class="empty-state">
                <h3>No tienes mensajes pendientes</h3>
                <p>Los mensajes que envíes estarán pendientes de moderación hasta que sean revisados.</p>
            </div>
        @else
            @foreach($pendingMessages as $message)
                <div class="message-card">
                    <div class="message-header">
                        <span class="message-user">{{ $message['user'] ?? 'Usuario' }}</span>
                        <span class="message-time">{{ $message['timestamp'] ?? 'Sin fecha' }}</span>
                    </div>
                    <div class="message-title">{{ $message['title'] ?? 'Sin título' }}</div>
                    <div class="message-text">{{ $message['text'] ?? 'Sin contenido' }}</div>
                    <span class="message-status status-pending">Pendiente de moderación</span>
                </div>
            @endforeach
        @endif
    </div>
    
    <!-- Tab Eliminados -->
    <div id="eliminados" class="tab-content">
        <h2>Mensajes Eliminados</h2>
        @if(empty($deletedMessages))
            <div class="empty-state">
                <h3>No tienes mensajes eliminados</h3>
                <p>Los mensajes que sean eliminados por los moderadores aparecerán aquí con la razón.</p>
            </div>
        @else
            @foreach($deletedMessages as $message)
                <div class="message-card">
                    <div class="message-header">
                        <span class="message-user">{{ $message['user'] ?? 'Usuario' }}</span>
                        <span class="message-time">{{ $message['timestamp'] ?? 'Sin fecha' }}</span>
                    </div>
                    <div class="message-title">{{ $message['title'] ?? 'Sin título' }}</div>
                    <div class="message-text">{{ $message['text'] ?? 'Sin contenido' }}</div>
                    <span class="message-status status-pending">Eliminado</span>
                    
                    @if(isset($message['delete_reason']))
                        <div class="delete-info">
                            <strong>Razón de eliminación:</strong>
                            <span>{{ $message['delete_reason'] }}</span>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</div>

<script>
    function showTab(tabName) {
        // Ocultar todos los tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });
        document.querySelectorAll('.tab').forEach(tab => {
            tab.classList.remove('active');
        });
        
        // Mostrar el tab seleccionado
        document.getElementById(tabName).classList.add('active');
        event.target.classList.add('active');
    }
</script>
@endsection