<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CulturaActiva - Inicio</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>

<body>
    <div class="container">
        <header>
            <h1>🎭 CulturaActiva</h1>
            <nav>
                @auth
                <span>Hola, {{ Auth::user()->nombre }}</span>
                @if(Auth::user()->rol === 'admin')
                <a href="{{ route('admin.dashboard') }}">Panel Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit">Cerrar Sesión</button>
                </form>
                @else
                <a href="{{ route('login') }}">Iniciar Sesión</a>
                <a href="{{ route('register') }}">Registrarse</a>
                @endauth
            </nav>
        </header>

        <main>
            <h2>Bienvenido a CulturaActiva</h2>
            <p>Plataforma de gestión de eventos culturales</p>

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="info">
                <p><strong>Estado del sistema:</strong></p>
                <ul>
                    <li>✅ Autenticación funcionando</li>
                    <li>⏳ API de eventos (próximamente)</li>
                    <li>⏳ Sistema de reservas (próximamente)</li>
                </ul>
            </div>
        </main>
    </div>

</body>

</html>