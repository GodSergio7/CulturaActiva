<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CulturaActiva - Eventos Culturales</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>

<body>
    <div id="inicio"></div>

    <nav class="navbar">
        <div class="navbar-logo">CulturaActiva</div>
        <ul>
            <li><a href="#inicio">Inicio</a></li>
            <li><a href="#eventos">Eventos</a></li>
            <li><a href="#categorias">Categorías</a></li>
            <li><a href="#calendario">Calendario</a></li>
            <li><a href="#contacto">Contacto</a></li>
            <li>
                @auth
                @if(Auth::user()->rol === 'admin')
                <a href="{{ route('admin.dashboard') }}">Panel Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-link" style="background: none; border: none; cursor: pointer; font-size: inherit; color: inherit; text-decoration: underline;">Cerrar sesión</button>
                </form>
                @else
                <a href="{{ route('login') }}">Iniciar sesión</a>
                @endauth
            </li>
        </ul>
    </nav>

    <header>
        <div class="header-top">
            <h1>CulturaActiva</h1>
            <p>Descubre los mejores eventos culturales de tu ciudad</p>
            @auth
            <span>Bienvenido, {{ Auth::user()->nombre }}</span>
            @else
            <a href="{{ route('login') }}"><button class="login-button">Iniciar sesión</button></a>
            @endauth
        </div>
        <div class="search-bar">
            <form>
                <input type="text" id="search-input" class="search-input" placeholder="Buscar eventos, categorías, lugares...">
                <button type="submit" class="search-button">Buscar</button>
            </form>
        </div>
    </header>

    <section id="eventos" class="eventos-section">
        <div class="eventos-container">
            <div class="eventos-header">
                <h2>Próximos Eventos</h2>
                <p>Descubre los mejores eventos culturales que hemos seleccionado para ti</p>
            </div>

            <main id="contenedor-eventos">
                @if (!empty($eventos))
                @foreach ($eventos as $evento)
                <div class="evento-card">
                    @if (!empty($evento['imagen']))
                    <img src="{{ $evento['imagen'] }}" alt="{{ $evento['titulo'] }}" class="evento-imagen">
                    @else
                    <div class="evento-imagen-placeholder">🎭</div>
                    @endif
                    <div class="evento-info">
                        <span class="evento-categoria">{{ $evento['categoria'] ?? 'General' }}</span>
                        <h3>{{ $evento['titulo'] }}</h3>
                        <p class="evento-descripcion">{{ $evento['descripcion'] }}</p>
                        <div class="evento-detalles">
                            <span>📅 {{ $evento['fecha'] }}</span>
                            <span>🕐 {{ $evento['hora'] }}</span>
                            <span>📍 {{ $evento['ubicacion'] }}</span>
                        </div>
                        <div class="evento-footer">
                            <span class="evento-precio">{{ $evento['precio'] }}€</span>
                            <button class="btn-reservar">Reservar</button>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="no-eventos">
                    <p>🎭 No hay eventos disponibles en momento. ¡Vuelve pronto!</p>
                </div>
                @endif
            </main>
        </div>
    </section>

    <section id="calendario" class="calendario-section">
        <div class="calendario-container">
            <div class="calendario-header">
                <span class="calendario-badge">Calendario</span>
                <h2>Próximamente</h2>
                <p>Aquí podrás ver todos los eventos en formato calendario</p>
            </div>
        </div>
    </section>

    <section id="categorias" class="categorias-section">
        <div class="categorias-container">
            <div class="categorias-header">
                <h2>Explora por Categoría</h2>
                <p>Descubre eventos culturales organizados por tus intereses favoritos</p>
            </div>

            <div class="categorias-grid">
                <div class="categoria-card musica">
                    <div class="categoria-icon">🎵</div>
                    <h3>Música</h3>
                    <p>Conciertos, festivales y recitales en vivo</p>
                </div>

                <div class="categoria-card arte">
                    <div class="categoria-icon">🎨</div>
                    <h3>Arte</h3>
                    <p>Exposiciones, galerías y arte contemporáneo</p>
                </div>

                <div class="categoria-card cine">
                    <div class="categoria-icon">🎬</div>
                    <h3>Cine</h3>
                    <p>Películas, documentales y festivales de cine</p>
                </div>

                <div class="categoria-card teatro">
                    <div class="categoria-icon">🎭</div>
                    <h3>Teatro</h3>
                    <p>Obras teatrales, comedia y performances</p>
                </div>

                <div class="categoria-card danza">
                    <div class="categoria-icon">💃</div>
                    <h3>Danza</h3>
                    <p>Ballet, danza contemporánea y folklore</p>
                </div>

                <div class="categoria-card literatura">
                    <div class="categoria-icon">📚</div>
                    <h3>Literatura</h3>
                    <p>Lecturas, presentaciones y clubes de lectura</p>
                </div>

                <div class="categoria-card talleres">
                    <div class="categoria-icon">✨</div>
                    <h3>Talleres</h3>
                    <p>Actividades prácticas y cursos creativos</p>
                </div>

                <div class="categoria-card gastronomia">
                    <div class="categoria-icon">🍷</div>
                    <h3>Gastronomía</h3>
                    <p>Degustaciones, festivales y catas</p>
                </div>
            </div>
        </div>
    </section>

    <section id="contacto" class="contacto-section">
        <div class="contacto-container">
            <div class="contacto-header">
                <h2>¿Tienes alguna pregunta?</h2>
                <p>Estamos aquí para ayudarte. Completa el formulario y nos pondremos en contacto contigo pronto.</p>
            </div>

            <div class="contacto-content">
                <form class="contacto-form">
                    <div class="form-group">
                        <label for="nombre">Nombre completo</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input type="email" id="email" name="email" placeholder="tu@email.com" required>
                    </div>

                    <div class="form-group">
                        <label for="asunto">Asunto</label>
                        <input type="text" id="asunto" name="asunto" placeholder="¿En qué podemos ayudarte?" required>
                    </div>

                    <div class="form-group">
                        <label for="mensaje">Mensaje</label>
                        <textarea id="mensaje" name="mensaje" rows="5" placeholder="Escribe tu mensaje aquí..." required></textarea>
                    </div>

                    <button type="submit" class="submit-button">Enviar mensaje</button>
                </form>

                <div class="contacto-info">
                    <div class="info-card">
                        <div class="info-icon">📍</div>
                        <h3>Ubicación</h3>
                        <p>Calle Principal 123<br>Ciudad, CP 12345</p>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">✉️</div>
                        <h3>Email</h3>
                        <p>info@culturaactiva.com<br>eventos@culturaactiva.com</p>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">📞</div>
                        <h3>Teléfono</h3>
                        <p>+34 123 456 789<br>Lunes a Viernes 9:00 - 18:00</p>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">🕒</div>
                        <h3>Horario</h3>
                        <p>Lunes - Viernes: 9:00 - 20:00<br>Sábado - Domingo: 10:00 - 14:00</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>© 2025 CulturaActiva. Todos los derechos reservados.</p>
    </footer>
</body>

</html>