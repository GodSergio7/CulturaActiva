/* =========================================
   1. BASE DE DATOS SIMULADA (LOCALSTORAGE)
   ========================================= */

// --- A. GESTIÓN DE EVENTOS ---
const datosIniciales = [
    { id: 1, titulo: "Concierto de Jazz", categoria: "Música", fecha: "2025-11-25", hora: "19:00", lugar: "Parque Central", descripcion: "Noche de Jazz bajo las estrellas.", precio: 15, estado: "active" },
    { id: 2, titulo: "Arte Moderno", categoria: "Arte", fecha: "2025-11-28", hora: "11:00", lugar: "Museo Reina Sofía", descripcion: "Exposición de obras innovadoras.", precio: 12, estado: "active" },
    { id: 3, titulo: "Cine Indie", categoria: "Cine", fecha: "2025-12-02", hora: "18:00", lugar: "Filmoteca", descripcion: "Proyección de cortos independientes.", precio: 8, estado: "draft" }
];

// Cargar Eventos del disco duro o usar iniciales
const eventosGuardados = localStorage.getItem('misEventos');
let eventos = eventosGuardados ? JSON.parse(eventosGuardados) : datosIniciales;

function guardarCambios() {
    localStorage.setItem('misEventos', JSON.stringify(eventos));
}

// --- B. GESTIÓN DE USUARIOS (Predefinidos) ---
const usuariosIniciales = [
    { email: "admin@cultura.com", pass: "1234", nombre: "Administrador", rol: "admin" },
    { email: "cliente@cultura.com", pass: "1234", nombre: "Cliente Ejemplo", rol: "cliente" }
];

// Cargar Usuarios (aunque no registremos, necesitamos leerlos para el login y la tabla)
const usuariosGuardados = localStorage.getItem('misUsuarios');
let usuarios = usuariosGuardados ? JSON.parse(usuariosGuardados) : usuariosIniciales;

// (Opcional) Guardamos los iniciales por si acaso se borra el caché
if (!usuariosGuardados) {
    localStorage.setItem('misUsuarios', JSON.stringify(usuarios));
}

/* =========================================
   2. LÓGICA DE RUTAS (Al cargar la página)
   ========================================= */
document.addEventListener("DOMContentLoaded", () => {
    // Detectamos en qué página estamos buscando elementos únicos
    const esIndex = document.getElementById("contenedor-eventos");
    const esLogin = document.querySelector(".login-form") || document.getElementById("form-login"); // Soporta ambos IDs

    // Para detectar Admin, buscamos el Dashboard o la lista
    const esAdmin = document.getElementById("dashboard") || document.querySelector(".events-list");

    if (esIndex) {
        cargarEventosIndex();
        configurarBuscador();
    } else if (esLogin) {
        configurarLogin();
    } else if (esAdmin) {
        // ADMIN: Cargamos todo el panel
        cargarEventosAdmin();
        configurarFormularioAdmin();
        cargarEstadisticas();
        cargarListaUsuarios();
    }
});

/* =========================================
   3. FUNCIONES DEL INDEX (Público)
   ========================================= */

function cargarEventosIndex(filtro = "") {
    const contenedor = document.getElementById('contenedor-eventos');
    if (!contenedor) return;

    contenedor.innerHTML = ''; // Limpiar

    // 1. FILTRAR
    const eventosFiltrados = eventos.filter(evento => {
        const esActivo = evento.estado === 'active';
        const coincideTitulo = evento.titulo.toLowerCase().includes(filtro.toLowerCase());
        const coincideCategoria = evento.categoria.toLowerCase().includes(filtro.toLowerCase());
        return esActivo && (coincideTitulo || coincideCategoria);
    });

    // 2. PINTAR
    if (eventosFiltrados.length === 0) {
        contenedor.innerHTML = '<p style="text-align:center; width:100%;">No se encontraron eventos.</p>';
        return;
    }

    eventosFiltrados.forEach(evento => {
        const html = `
            <article class="evento-card">
                <h3>${evento.titulo}</h3>
                <p><strong>Categoría:</strong> ${evento.categoria}</p>
                <p><strong>Fecha:</strong> ${evento.fecha} | ${evento.hora}</p>
                <p><strong>Lugar:</strong> ${evento.lugar}</p>
                <p>${evento.descripcion.substring(0, 100)}...</p>
                <button onclick="verDetalle(${evento.id})">Más información</button>
            </article>
        `;
        contenedor.innerHTML += html;
    });
}

function configurarBuscador() {
    const inputBusqueda = document.querySelector('.search-input');
    const botonBusqueda = document.querySelector('.search-button');

    // Búsqueda en tiempo real
    if (inputBusqueda) {
        inputBusqueda.addEventListener('input', (e) => {
            const texto = e.target.value;
            cargarEventosIndex(texto);
        });
    }

    // Búsqueda por botón
    if (botonBusqueda) {
        botonBusqueda.addEventListener('click', (e) => {
            e.preventDefault();
            cargarEventosIndex(inputBusqueda.value);
        });
    }
}

function verDetalle(id) {
    const evento = eventos.find(e => e.id === id);
    if (!evento) return;

    alert(`
    📅 ${evento.titulo.toUpperCase()} 
    --------------------------------
    📂 Categoría: ${evento.categoria}
    📍 Lugar: ${evento.lugar}
    🕒 Fecha: ${evento.fecha} a las ${evento.hora}
    💰 Precio: ${evento.precio}€
    
    ℹ️ Descripción:
    ${evento.descripcion}
    `);
}

/* =========================================
   4. FUNCIONES DEL LOGIN (Simplificado)
   ========================================= */

function configurarLogin() {
    // Buscamos el formulario por clase o ID
    const form = document.querySelector(".login-form") || document.getElementById("form-login");

    if (form) {
        form.addEventListener("submit", (e) => {
            e.preventDefault();

            // Intentamos coger los valores (soporta IDs antiguos y nuevos)
            const emailInput = document.getElementById("email") || document.getElementById("login-email");
            const passInput = document.getElementById("password") || document.getElementById("login-pass");

            const email = emailInput.value;
            const pass = passInput.value;

            // VALIDACIÓN: Buscamos en el array de usuarios
            const usuarioValido = usuarios.find(u => u.email === email && u.pass === pass);

            if (usuarioValido) {
                alert(`¡Bienvenido, ${usuarioValido.nombre}!`);

                // Redirigir según rol
                if (usuarioValido.rol === 'admin') {
                    // Como login.html y admin.html son vecinos (están en la misma carpeta), esto vale:
                    window.location.href = "admin.html";
                } else {
                    // Como index.html está FUERA (un nivel arriba), usamos ../
                    window.location.href = "../index.html";
                }
            } else {
                alert("❌ Error: Email o contraseña incorrectos.\n(Prueba: admin@cultura.com / 1234)");
            }
        });
    }
}

/* =========================================
   5. FUNCIONES DEL ADMIN (Gestión)
   ========================================= */

function cargarEventosAdmin() {
    const lista = document.querySelector(".events-list");
    if (!lista) return;

    lista.innerHTML = "";

    eventos.forEach((evento) => {
        let claseEstado = "";
        if (evento.estado === "active") claseEstado = "active";
        else if (evento.estado === "draft") claseEstado = "draft";
        else claseEstado = "cancelled";

        const html = `
            <div class="event-item">
                <div class="event-item-header">
                    <div>
                        <h3>${evento.titulo}</h3>
                        <p class="event-meta">
                            ${evento.categoria} • ${evento.fecha}
                        </p>
                    </div>
                    <span class="status-badge ${claseEstado}">${evento.estado}</span>
                </div>
                <div class="event-item-actions">
                    <button class="action-btn edit" onclick="cargarDatosEnFormulario(${evento.id})">✏️ Editar</button>
                    <button class="action-btn delete" onclick="borrarEvento(${evento.id})">🗑️ Eliminar</button>
                </div>
            </div>
        `;
        lista.innerHTML += html;
    });
}

// ESTADÍSTICAS DEL DASHBOARD
function cargarEstadisticas() {
    // 1. Calcular datos
    const totalEventos = eventos.length;
    const eventosActivos = eventos.filter(e => e.estado === 'active').length;
    const totalUsuarios = usuarios.length;

    // 2. Pintar en el HTML
    if (document.getElementById('stat-total-eventos')) {
        document.getElementById('stat-total-eventos').textContent = totalEventos;
        document.getElementById('stat-activos').textContent = eventosActivos;
        document.getElementById('stat-usuarios').textContent = totalUsuarios;
    }
}

// TABLA DE USUARIOS
function cargarListaUsuarios() {
    const tablaUsuarios = document.getElementById('tabla-usuarios-body');
    if (!tablaUsuarios) return;

    tablaUsuarios.innerHTML = '';

    usuarios.forEach(usuario => {
        const row = `
            <tr>
                <td>${usuario.nombre}</td>
                <td>${usuario.email}</td>
                <td><span class="user-badge ${usuario.rol}">${usuario.rol}</span></td>
                <td><span class="status-badge active" style="font-size:10px;">Activo</span></td>
            </tr>
        `;
        tablaUsuarios.innerHTML += row;
    });
}

/* =========================================
   6. CREAR, EDITAR Y BORRAR (CRUD)
   ========================================= */

let idEventoEditando = null;

function configurarFormularioAdmin() {
    const form = document.querySelector('.admin-form');
    const btnSubmit = document.querySelector('.btn-primary');

    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            const datosFormulario = {
                titulo: document.getElementById('evento-titulo').value,
                categoria: document.getElementById('evento-categoria').value,
                estado: document.getElementById('evento-estado').value,
                fecha: document.getElementById('evento-fecha').value,
                hora: document.getElementById('evento-hora').value,
                lugar: document.getElementById('evento-lugar').value,
                precio: document.getElementById('evento-precio').value,
                descripcion: document.getElementById('evento-descripcion').value,
                imagen: document.getElementById('evento-imagen').value || 'img/default.jpg'
            };

            if (idEventoEditando === null) {
                // A) MODO CREAR
                const nuevoEvento = { ...datosFormulario, id: Date.now() };
                eventos.push(nuevoEvento);
                alert('✅ ¡Evento creado correctamente!');
            } else {
                // B) MODO EDITAR
                const index = eventos.findIndex(e => e.id === idEventoEditando);
                if (index !== -1) {
                    eventos[index] = { ...datosFormulario, id: idEventoEditando };
                    alert('💾 ¡Evento actualizado correctamente!');
                }
                idEventoEditando = null;
                if (btnSubmit) {
                    btnSubmit.textContent = "Publicar evento";
                    btnSubmit.style.backgroundColor = "";
                }
            }

            // ACTUALIZAR TODO
            guardarCambios();
            cargarEventosAdmin();
            cargarEstadisticas();
            form.reset();
        });
    }
}

function borrarEvento(idParaBorrar) {
    const confirmar = confirm("¿Estás seguro de que quieres eliminar este evento?");

    if (confirmar) {
        eventos = eventos.filter(evento => evento.id !== idParaBorrar);
        guardarCambios();
        cargarEventosAdmin();
        cargarEstadisticas();
    }
}

function cargarDatosEnFormulario(id) {
    const evento = eventos.find(e => e.id === id);
    if (!evento) return;

    idEventoEditando = id;

    // Rellenar campos
    document.getElementById('evento-titulo').value = evento.titulo;
    document.getElementById('evento-categoria').value = evento.categoria;
    document.getElementById('evento-estado').value = evento.estado;
    document.getElementById('evento-fecha').value = evento.fecha;
    document.getElementById('evento-hora').value = evento.hora;
    document.getElementById('evento-lugar').value = evento.lugar;
    document.getElementById('evento-precio').value = evento.precio;
    document.getElementById('evento-descripcion').value = evento.descripcion;
    if (document.getElementById('evento-imagen')) {
        document.getElementById('evento-imagen').value = evento.imagen;
    }

    // Cambiar botón visualmente
    const btnSubmit = document.querySelector('.btn-primary');
    if (btnSubmit) {
        btnSubmit.textContent = "💾 Guardar Cambios";
        btnSubmit.style.backgroundColor = "#f39c12";
    }

    // Scroll hacia arriba
    document.querySelector('.admin-form').scrollIntoView({ behavior: 'smooth' });
}