<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventoController extends Controller
{
    // Página principal pública
    public function index()
    {
        // Eventos temporales (hasta que conectemos la API Python)
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

        return view('welcome', compact('eventos'));
    }
}
