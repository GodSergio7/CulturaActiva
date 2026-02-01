<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - CulturaActiva</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-styles.css') }}">
</head>

<body class="admin-page">
    <nav class="navbar">
        <div class="navbar-logo">CulturaActiva <span class="admin-badge-nav">Admin</span></div>
        <ul>
            <li><a href="#dashboard">Dashboard</a></li>
            <li><a href="#eventos">Eventos</a></li>
            <li><a href="#usuarios">Usuarios</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-link" style="background: none; border: none; cursor: pointer; font-size: inherit; color: inherit; text-decoration: underline;">Cerrar sesión</button>
                </form>
            </li>
        </ul>
    </nav>

    <div class="admin-container">
        <div class="admin-decoration">
            <div class="decoration-circle circle-1"></div>
            <div class="decoration-circle circle-2"></div>
            <div class="decoration-circle circle-3"></div>
        </div>

        <div class="admin-header">
            <div class="admin-welcome">
                <div class="admin-icon">⚙️</div>
                <div>
                    <h1>Panel de Administración</h1>
                    <p>Bienvenido, {{ Auth::user()->nombre }} {{ Auth::user()->apellidos }}</p>
                </div>
            </div>

            <div id="dashboard" class="dashboard-stats">
                <div class="stat-card blue">
                    <div class="stat-icon">📅</div>
                    <div class="stat-content">
                        <div class="stat-number blue">{{ $totalEventos ?? 0 }}</div>
                        <div class="stat-label">Eventos Totales</div>
                    </div>
                </div>
                <div class="stat-card green">
                    <div class="stat-icon">✅</div>
                    <div class="stat-content">
                        <div class="stat-number green">{{ $eventosActivos ?? 0 }}</div>
                        <div class="stat-label">Eventos Activos</div>
                    </div>
                </div>
                <div class="stat-card orange">
                    <div class="stat-icon">👥</div>
                    <div class="stat-content">
                        <div class="stat-number orange">{{ $totalUsuarios ?? 0 }}</div>
                        <div class="stat-label">Usuarios Registrados</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-content">

            <div class="main-column" style="display: flex; flex-direction: column; gap: 30px;">

                <div id="eventos" class="form-section">
                    <div class="section-header">
                        <h2>Editor de Eventos</h2>
                        <p>Crea o modifica eventos culturales</p>
                    </div>

                    @if (session('success'))
                    <div class="alert alert-success">
                        <p>{{ session('success') }}</p>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-error">
                        @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif

                    <form class="admin-form" method="POST" action="{{ route('admin.eventos.crear') }}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group full-width">
                                <label for="titulo">Título del evento *</label>
                                <input type="text" id="titulo" name="titulo" value="{{ old('titulo') }}"
                                    placeholder="Ej: Concierto de Jazz en el Parque" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="id_categoria">Categoría *</label>
                                <select id="id_categoria" name="id_categoria" required>
                                    <option value="">Selecciona una categoría</option>
                                    @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria['id_categoria'] }}" {{ old('id_categoria') == $categoria['id_categoria'] ? 'selected' : '' }}>
                                        {{ $categoria['nombre'] }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="estado">Estado *</label>
                                <select id="estado" name="estado" required>
                                    <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>✅ Activo</option>
                                    <option value="borrador" {{ old('estado') == 'borrador' ? 'selected' : '' }} selected>📝 Borrador</option>
                                    <option value="cancelado" {{ old('estado') == 'cancelado' ? 'selected' : '' }}>❌ Cancelado</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="fecha">Fecha *</label>
                                <input type="date" id="fecha" name="fecha" value="{{ old('fecha') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="hora">Hora *</label>
                                <input type="time" id="hora" name="hora" value="{{ old('hora') }}" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group full-width">
                                <label for="ubicacion">Lugar *</label>
                                <input type="text" id="ubicacion" name="ubicacion" value="{{ old('ubicacion') }}" placeholder="Ej: Parque Central" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="precio">Precio (€)</label>
                                <input type="number" id="precio" name="precio" value="{{ old('precio') }}" placeholder="0.00" min="0" step="0.01">
                            </div>
                            <div class="form-group">
                                <label for="aforo_maximo">Aforo máximo *</label>
                                <input type="number" id="aforo_maximo" name="aforo_maximo" value="{{ old('aforo_maximo') }}" placeholder="100" min="1" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group full-width">
                                <label for="imagen">URL Imagen (Opcional)</label>
                                <input type="text" id="imagen" name="imagen" value="{{ old('imagen') }}" placeholder="https://...">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group full-width">
                                <label for="descripcion">Descripción *</label>
                                <textarea id="descripcion" name="descripcion" rows="5"
                                    placeholder="Describe el evento..." required>{{ old('descripcion') }}</textarea>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-primary">Publicar evento</button>
                        </div>
                    </form>
                </div>

                <div id="usuarios" class="users-list-section">
                    <div class="section-header">
                        <h2>Gestión de Usuarios</h2>
                        <p>Usuarios registrados en la plataforma</p>
                    </div>
                    <div class="table-responsive">
                        <table class="users-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->nombre }} {{ $usuario->apellidos }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>
                                        <span class="badge {{ $usuario->rol === 'admin' ? 'badge-admin' : 'badge-cliente' }}">
                                            {{ ucfirst($usuario->rol) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $usuario->activo ? 'badge-activo' : 'badge-inactivo' }}">
                                            {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="events-list-section">
                <div class="section-header">
                    <h2>📋 Eventos Recientes</h2>
                    <p>Últimos eventos publicados</p>
                </div>

                <div class="events-list">
                    @foreach ($eventos as $evento)
                    <div class="event-card">
                        <div class="event-card-header">
                            <h3>{{ $evento['titulo'] }}</h3>
                            <span class="badge estado-{{ $evento['estado'] }}">
                                {{ ucfirst($evento['estado']) }}
                            </span>
                        </div>
                        <div class="event-card-body">
                            <p>📅 {{ $evento['fecha'] }} a las {{ $evento['hora'] }}</p>
                            <p>📍 {{ $evento['ubicacion'] }}</p>
                            <p>💰 {{ $evento['precio'] }}€</p>
                        </div>
                        <div class="event-card-actions">
                            <button class="btn-edit">✏️ Editar</button>
                            <form method="POST" action="{{ route('admin.eventos.eliminar', $evento['id_evento']) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="return confirm('¿Estás seguro de eliminar este evento?')">🗑️ Eliminar</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <footer>
        <p>© 2025 CulturaActiva. Todos los derechos reservados.</p>
    </footer>
</body>

</html>