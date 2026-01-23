<!DOCTYPE html>
<html lang="es" data-theme="{{ session('theme', 'light') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NosaNet')</title>
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    @stack('styles')

    <script>
        // Cargar tema de cookie si no está en HTML
        document.addEventListener('DOMContentLoaded', function() {
            const html = document.documentElement;
            if (!html.hasAttribute('data-theme')) {
                const themeCookie = document.cookie
                    .split('; ')
                    .find(row => row.startsWith('theme='));
                
                if (themeCookie) {
                    const theme = themeCookie.split('=')[1];
                    html.setAttribute('data-theme', theme);
                } else {
                    html.setAttribute('data-theme', 'light');
                }
            }
        });
    </script>
</head>
<body>
    <header>
        <a href="{{ route('home') }}" style="font-size: 1.5rem; font-weight: 700;">NosaNet</a>
        <div>
            @if(auth_check())
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('messages.my') }}">Mis Posts</a>
                
                @if(is_professor())
                    <a href="{{ route('moderation.index') }}">Moderación</a>
                @endif
                
                <div class="profile-dropdown">
                    <button type="button" class="profile-btn" onclick="toggleDropdown(event)">
                        Perfil
                    </button>
                    <div class="dropdown-content" id="profileDropdown">
                        <div class="user-info">
                            <div><strong>{{ session('username') }}</strong></div>
                            <div>{{ session('email') }}</div>
                            <div>
                                <span class="user-role">
                                    {{ is_professor() ? 'Profesor' : 'Alumno' }}
                                </span>
                            </div>
                        </div>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="logout-btn">Cerrar Sesión</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('register') }}">Registrarse</a>
                <a href="{{ route('login') }}">Iniciar Sesión</a>
            @endif
        </div>
    </header>
    
    <main>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
        
        @if(session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif
        
        @yield('content')
    </main>
    
    <!-- Selector de Tema -->
    <div class="theme-toggle-container">
        <form method="post" action="{{ route('theme.toggle') }}" class="theme-toggle-form">
            @csrf
            <button type="submit" class="theme-toggle-btn" title="Cambiar tema">
                <span class="theme-icon">
                    {{ session('theme', 'light') === 'dark' ? '☀️' : '🌙' }}
                </span>
                <span class="theme-text">
                    {{ session('theme', 'light') === 'dark' ? 'Modo Claro' : 'Modo Oscuro' }}
                </span>
            </button>
        </form>
    </div>
    
    @stack('scripts')
    
    <script>
        // Función para mostrar/ocultar el dropdown
        function toggleDropdown(event) {
            event.preventDefault();
            event.stopPropagation();
            
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('show');
        }
        
        // Cerrar el dropdown al hacer clic fuera
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('profileDropdown');
            const profileBtn = document.querySelector('.profile-btn');
            
            // Si el clic NO fue en el dropdown NI en el botón del perfil
            if (dropdown && profileBtn) {
                const isClickInsideDropdown = dropdown.contains(event.target);
                const isClickOnProfileBtn = profileBtn.contains(event.target) || event.target === profileBtn;
                
                if (!isClickInsideDropdown && !isClickOnProfileBtn) {
                    dropdown.classList.remove('show');
                }
            }
        });
        
        // Cerrar el dropdown con Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const dropdown = document.getElementById('profileDropdown');
                if (dropdown) {
                    dropdown.classList.remove('show');
                }
            }
        });
    </script>
</body>
</html>