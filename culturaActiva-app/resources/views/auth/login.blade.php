<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - CulturaActiva</title>
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
                <h1>Bienvenido de nuevo</h1>
                <p>Inicia sesión para acceder a tu cuenta de CulturaActiva</p>
            </div>

            @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            @if (session('success'))
            <div class="alert alert-success">
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <form class="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="tu@email.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                </div>
                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Recordarme</label>
                    </div>
                    <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
                </div>
                <button type="submit" class="login-submit-button">Iniciar sesión</button>
            </form>
            <div class="login-footer">
                <p>¿No tienes una cuenta? <a href="{{ route('register') }}" class="register-link">Regístrate aquí</a></p>
            </div>
        </div>
    </div>
    <footer>
        <p>© 2025 CulturaActiva. Todos los derechos reservados.</p>
    </footer>
</body>

</html>