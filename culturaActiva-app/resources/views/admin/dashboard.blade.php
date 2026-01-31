<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - CulturaActiva</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-styles.css') }}">
</head>

<body>
    <div class="container">
        <header>
            <h1>🎭 Panel de Administración</h1>
            <nav>
                <a href="{{ route('home') }}">Ir al sitio público</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Cerrar Sesión</button>
                </form>
            </nav>
        </header>

        <div class="admin-content">
            <h2>Bienvenido, {{ Auth::user()->nombre }} {{ Auth::user()->apellidos }}</h2>
            <p>Email: {{ Auth::user()->email }}</p>
            <p>Rol: <strong>{{ Auth::user()->rol }}</strong></p>

            <div class="admin-sections">
                <div class="card">
                    <h3>📅 Gestión de Eventos</h3>
                    <p>Aquí podrás crear, editar y eliminar eventos</p>
                    <p><em>(Próximamente cuando conectemos la API)</em></p>
                </div>

                <div class="card">
                    <h3>👥 Usuarios Registrados</h3>
                    <p>Total de usuarios en el sistema</p>
                    <p><em>(Próximamente)</em></p>
                </div>

                <div class="card">
                    <h3>📊 Estadísticas</h3>
                    <p>Ver estadísticas de eventos y reservas</p>
                    <p><em>(Próximamente)</em></p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>