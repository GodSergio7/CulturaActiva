<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - CulturaActiva</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login-styles.css') }}">
</head>

<body class="login-page">
    <nav class="navbar">
        <div class="navbar-logo">CulturaActiva</div>
        <ul>
            <li><a href="{{ route('home') }}">Volver al inicio</a></li>
        </ul>
    </nav>
    <div class="login-container">
        <div class="login-decoration">
            <div class="decoration-circle circle-1"></div>
            <div class="decoration-circle circle-2"></div>
            <div class="decoration-circle circle-3"></div>
        </div>
        <div class="login-box">
            <div class="login-header">
                <h1>Crear cuenta</h1>
                <p>Regístrate para disfrutar de los eventos culturales</p>
            </div>

            @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form class="login-form" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" placeholder="Tu nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos" value="{{ old('apellidos') }}" placeholder="Tus apellidos" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="tu@email.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Mínimo 6 caracteres" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repite tu contraseña" required>
                </div>
                <button type="submit" class="login-submit-button">Registrarse</button>
            </form>
            <div class="login-footer">
                <p>¿Ya tienes cuenta? <a href="{{ route('login') }}" class="register-link">Inicia sesión aquí</a></p>
            </div>
        </div>
    </div>
    <footer>
        <p>© 2025 CulturaActiva. Todos los derechos reservados.</p>
    </footer>
</body>

</html>