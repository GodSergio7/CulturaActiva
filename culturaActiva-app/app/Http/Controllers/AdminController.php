<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    protected $apiUrl = 'http://localhost:8000'; // URL de la API Python (la cambiaremos después)

    // Dashboard principal
    public function dashboard()
    {
        // Usuarios desde Laravel
        $usuarios = Usuario::all();
        $totalUsuarios = Usuario::count();

        // Eventos y categorías desde la API (por ahora datos temporales)
        // Eventos temporales de ejemplo (hasta que conectemos la API)
        $eventos = [
            [
                'id_evento' => 1,
                'titulo' => 'Concierto de Jazz en el Parque',
                'descripcion' => 'Una noche de jazz al aire libre con los mejores músicos de la ciudad.',
                'fecha' => '2025-03-15',
                'hora' => '19:00',
                'ubicacion' => 'Parque Central',
                'imagen' => '',
                'precio' => '15.00',
                'estado' => 'activo',
                'categoria' => 'Música'
            ],
            [
                'id_evento' => 2,
                'titulo' => 'Exposición de Arte Moderno',
                'descripcion' => 'Descubre las obras más innovadoras de artistas locales y nacionales.',
                'fecha' => '2025-03-20',
                'hora' => '10:00',
                'ubicacion' => 'Galería Central',
                'imagen' => '',
                'precio' => '10.00',
                'estado' => 'activo',
                'categoria' => 'Arte'
            ],
            [
                'id_evento' => 3,
                'titulo' => 'Festival de Cine Independiente',
                'descripcion' => 'Tres días de películas independientes seleccionadas por expertos.',
                'fecha' => '2025-04-01',
                'hora' => '17:00',
                'ubicacion' => 'Teatro Central',
                'imagen' => '',
                'precio' => '8.00',
                'estado' => 'activo',
                'categoria' => 'Cine'
            ]
        ];
        $categorias = [
            ['id_categoria' => 1, 'nombre' => 'Música'],
            ['id_categoria' => 2, 'nombre' => 'Teatro'],
            ['id_categoria' => 3, 'nombre' => 'Arte'],
            ['id_categoria' => 4, 'nombre' => 'Cine'],
        ];
        $totalEventos = count($eventos);
        $eventosActivos = count(array_filter($eventos, fn($e) => $e['estado'] === 'activo'));

        return view('admin.dashboard', compact(
            'usuarios',
            'totalUsuarios',
            'eventos',
            'categorias',
            'totalEventos',
            'eventosActivos'
        ));
    }

    // Crear evento (por ahora guarda datos temporales, después conectará a la API)
    public function crearEvento(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:150',
            'id_categoria' => 'required',
            'estado' => 'required|in:activo,borrador,cancelado',
            'fecha' => 'required|date',
            'hora' => 'required',
            'ubicacion' => 'required|string|max:150',
            'precio' => 'nullable|numeric|min:0',
            'aforo_maximo' => 'required|integer|min:1',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|string',
        ]);

        // Cuando tengamos la API Python, aquí haremos:
        // Http::post($this->apiUrl . '/eventos', $request->all());

        return redirect()->route('admin.dashboard')->with('success', '¡Evento creado correctamente!');
    }

    // Eliminar evento
    public function eliminarEvento($id)
    {
        // Cuando tengamos la API Python, aquí haremos:
        // Http::delete($this->apiUrl . '/eventos/' . $id);

        return redirect()->route('admin.dashboard')->with('success', '¡Evento eliminado correctamente!');
    }
}
