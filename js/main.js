/* =========================================
   1. BASE DE DATOS SIMULADA (CON LOCALSTORAGE)
   ========================================= */

// Datos de prueba (solo se usarán la primera vez)
const datosIniciales = [
    {
        id: 1,
        titulo: "Concierto de Jazz en el Parque",
        categoria: "Música",
        fecha: "2025-11-25",
        hora: "19:00",
        lugar: "Parque Central",
        descripcion: "Una noche mágica con los mejores músicos de jazz.",
        precio: 15.00,
        estado: "active"
    },
    {
        id: 2,
        titulo: "Arte Contemporáneo",
        categoria: "Arte",
        fecha: "2025-11-28",
        hora: "11:00",
        lugar: "Museo de Arte Moderno",
        descripcion: "Descubre las obras más innovadoras.",
        precio: 12.50,
        estado: "active"
    },
    {
        id: 3,
        titulo: "Festival de Cine Indie",
        categoria: "Cine",
        fecha: "2025-12-02",
        hora: "18:00",
        lugar: "Teatro Municipal",
        descripcion: "Proyección de cortometrajes independientes.",
        precio: 8.00,
        estado: "draft"

    }
];

// CÓDIGO INTELIGENTE:
// 1. Intentamos leer del 'disco duro' del navegador (localStorage)
const eventosGuardados = localStorage.getItem('misEventos');

// 2. Si hay algo guardado, lo usamos. Si no, usamos los iniciales.
let eventos = eventosGuardados ? JSON.parse(eventosGuardados) : datosIniciales;

// Función auxiliar para guardar cambios (La llamaremos cada vez que modifiquemos algo)
function guardarCambios() {
    localStorage.setItem('misEventos', JSON.stringify(eventos));
}

// ARRAY DE USUARIOS: Para simular el login.
const usuarios = [
    {
        email: "admin@cultura.com",
        pass: "1234",
        nombre: "Administrador",
    },
];

/* =========================================
   2. LÓGICA DE RUTAS (¿En qué página estoy?)
   ========================================= */

document.addEventListener("DOMContentLoaded", () => {
    // Detectamos en qué página estamos buscando elementos únicos
    const esIndex = document.getElementById("contenedor-eventos");
    const esLogin = document.querySelector(".login-form");
    const esAdmin = document.querySelector(".events-list");

    if (esIndex) {
        cargarEventosIndex();
        configurarBuscador();
    } else if (esLogin) {
        configurarLogin();
    } else if (esAdmin) {
        cargarEventosAdmin();
        configurarFormularioAdmin();
    }
});

/* =========================================
   3. FUNCIONES DEL INDEX (Público) - MEJORADAS
   ========================================= */

//función acepta un texto para filtrar
function cargarEventosIndex(filtro = "") {
    const contenedor = document.getElementById('contenedor-eventos');
    contenedor.innerHTML = ''; // Limpiar

    // 1. FILTRAR: Creamos un nuevo array solo con lo que coincida
    const eventosFiltrados = eventos.filter(evento => {
        // Condiciones: Que esté activo Y que el título coincida con lo que buscamos
        const esActivo = evento.estado === 'active';
        const coincideTitulo = evento.titulo.toLowerCase().includes(filtro.toLowerCase());
        const coincideCategoria = evento.categoria.toLowerCase().includes(filtro.toLowerCase());

        // Devolvemos true si cumple (Activo) Y (Titulo O Categoria coinciden)
        return esActivo && (coincideTitulo || coincideCategoria);
    });

    // 2. PINTAR: Si no hay resultados, mostramos mensaje
    if (eventosFiltrados.length === 0) {
        contenedor.innerHTML = '<p style="text-align:center">No se encontraron eventos con esa búsqueda.</p>';
        return;
    }

    // 3. RECORRER: Usamos el array ya filtrado
    eventosFiltrados.forEach(evento => {
        const html = `
            <article class="evento-card">
                <h3>${evento.titulo}</h3>
                <p><strong>Categoría:</strong> ${evento.categoria}</p>
                <p><strong>Fecha:</strong> ${evento.fecha} | ${evento.hora}</p>
                <p><strong>Lugar:</strong> ${evento.lugar}</p>
                <p>${evento.descripcion}</p>
                <button onclick="verDetalle(${evento.id})">Más información</button>
            </article>
        `;
        contenedor.innerHTML += html;
    });
}

/* --- LÓGICA DEL BUSCADOR --- */
// Esto va dentro del bloque document.addEventListener('DOMContentLoaded', ...)
// O puedes llamar a esta función 'configurarBuscador()' dentro del IF del Index.

function configurarBuscador() {
    const inputBusqueda = document.querySelector('.search-input');
    const botonBusqueda = document.querySelector('.search-button');

    // Opción A: Buscar al hacer clic en el botón
    if (botonBusqueda) {
        botonBusqueda.addEventListener('click', (e) => {
            e.preventDefault(); // Para que no recargue la página
            const texto = inputBusqueda.value;
            cargarEventosIndex(texto); // ¡Aquí llamamos a la función con el filtro!
        });
    }

    // Opción B: Buscar en tiempo real mientras escribes (más moderno)
    if (inputBusqueda) {
        inputBusqueda.addEventListener('input', (e) => {
            const texto = e.target.value;
            cargarEventosIndex(texto);
        });
    }
}

function verDetalle(id) {
    alert(`Aquí iríamos al detalle del evento con ID: ${id}`);
    // En el futuro: window.location.href = 'detalle.html?id=' + id;
}

/* =========================================
   4. FUNCIONES DEL LOGIN (Validación)
   ========================================= */

function configurarLogin() {
    const form = document.querySelector(".login-form");

    form.addEventListener("submit", (e) => {
        e.preventDefault(); // Evita que la página se recargue

        // Capturamos lo que escribió el usuario
        const emailInput = document.getElementById("email").value;
        const passInput = document.getElementById("password").value;

        // VALIDACIÓN CON ARRAY: Buscamos si existe el usuario
        // .find() es un método de arrays que busca una coincidencia
        const usuarioValido = usuarios.find(
            (u) => u.email === emailInput && u.pass === passInput
        );

        if (usuarioValido) {
            alert(`¡Bienvenido, ${usuarioValido.nombre}!`);
            window.location.href = "admin.html"; // Redirigimos al admin
        } else {
            alert(
                "❌ Error: Email o contraseña incorrectos.\n(Prueba: admin@cultura.com / 1234)"
            );
        }
    });
}

/* =========================================
    5. FUNCIONES DEL ADMIN (Gestión)
   ========================================= */

function cargarEventosAdmin() {
    const lista = document.querySelector(".events-list");
    lista.innerHTML = "";

    // Reutilizamos el MISMO array 'eventos', pero con otro diseño HTML
    eventos.forEach((evento) => {
        // Clase dinámica según el estado (para colorear la etiqueta)
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
                            ${evento.categoria} • ${evento.fecha} • ${evento.hora}
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

/* =========================================
    6. CREAR Y EDITAR (Formulario Inteligente)
   ========================================= */

function configurarFormularioAdmin() {
    const form = document.querySelector('.admin-form');
    const btnSubmit = document.querySelector('.btn-primary');

    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            // Recogemos datos comunes
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

            // --- LÓGICA DE DECISIÓN ---
            if (idEventoEditando === null) {
                // A) MODO CREAR (Como antes)
                const nuevoEvento = { ...datosFormulario, id: Date.now() }; // Spread operator para copiar datos + ID nuevo
                eventos.push(nuevoEvento);
                alert('✅ ¡Evento creado correctamente!');
            } else {
                // B) MODO EDITAR (Nuevo para flexear)
                // Buscamos la posición del evento en el array
                const index = eventos.findIndex(e => e.id === idEventoEditando);

                if (index !== -1) {
                    // Mantenemos el ID original, pero actualizamos el resto
                    eventos[index] = { ...datosFormulario, id: idEventoEditando };
                    alert('💾 ¡Evento actualizado correctamente!');
                }

                // Reseteamos el modo edición
                idEventoEditando = null;
                btnSubmit.textContent = "Publicar evento";
                btnSubmit.style.backgroundColor = ""; // Volver al color original
            }

            // --- FINALIZAR ---
            guardarCambios();      // Guardar en localStorage
            cargarEventosAdmin();  // Repintar la lista
            form.reset();          // Limpiar formulario
        });
    }
}


/* =========================================
    7. BORRAR EVENTOS (USANDO FILTER)
   ========================================= */

function borrarEvento(idParaBorrar) {
    // 1. Confirmación de seguridad (buena práctica UX)
    const confirmar = confirm("¿Estás seguro de que quieres eliminar este evento?");

    if (confirmar) {
        // 2. EL FILTRO MÁGICO
        eventos = eventos.filter(evento => evento.id !== idParaBorrar);

        // 3. ACTUALIZAR TODO
        guardarCambios();      // Guardamos la nueva lista en localStorage
        cargarEventosAdmin();  // Repintamos la pantalla (el evento desaparecerá)
    }
}

/* =========================================
    8. EDITAR EVENTOS (Modo Edición)
   ========================================= */

let idEventoEditando = null; // Variable global para saber qué estamos haciendo

function cargarDatosEnFormulario(id) {
    // 1. Buscamos el evento en el array
    const evento = eventos.find(e => e.id === id);
    if (!evento) return;

    // 2. Guardamos el ID en la variable global para acordarnos luego
    idEventoEditando = id;

    // 3. Rellenamos el formulario con los datos del evento
    document.getElementById('evento-titulo').value = evento.titulo;
    document.getElementById('evento-categoria').value = evento.categoria;
    document.getElementById('evento-estado').value = evento.estado;
    document.getElementById('evento-fecha').value = evento.fecha;
    document.getElementById('evento-hora').value = evento.hora;
    document.getElementById('evento-lugar').value = evento.lugar;
    document.getElementById('evento-precio').value = evento.precio;
    document.getElementById('evento-descripcion').value = evento.descripcion;
    document.getElementById('evento-imagen').value = evento.imagen;

    // (Opcional) Si tienes campo de 'organizador', rellénalo también.

    // 4. CAMBIO VISUAL: Avisamos al usuario de que está editando
    const btnSubmit = document.querySelector('.btn-primary');
    btnSubmit.textContent = "💾 Guardar Cambios";
    btnSubmit.style.backgroundColor = "#f39c12"; // Ponemos el botón naranja para que se note

    // 5. Scroll suave hacia arriba para que vea el formulario
    document.querySelector('.admin-form').scrollIntoView({ behavior: 'smooth' });
}