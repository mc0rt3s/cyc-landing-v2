<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicSiteController extends Controller
{
    public function home()
    {
        // Datos de ejemplo para las circulares
        $circulars = collect([
            (object) [
                'title' => 'Nuevas disposiciones tributarias 2025',
                'summary' => 'Información sobre los cambios en la normativa tributaria para el año 2025 y sus implicaciones para las empresas.',
                'category' => (object) ['name' => 'Tributario'],
                'published_at' => now()->subDays(5),
                'slug' => 'nuevas-disposiciones-tributarias-2025'
            ],
            (object) [
                'title' => 'Actualización de salarios mínimos',
                'summary' => 'Nuevos montos de salarios mínimos vigentes desde enero de 2025 y su impacto en la planilla de remuneraciones.',
                'category' => (object) ['name' => 'Laboral'],
                'published_at' => now()->subDays(10),
                'slug' => 'actualizacion-salarios-minimos-2025'
            ],
            (object) [
                'title' => 'Nuevos estándares contables',
                'summary' => 'Actualización de los estándares contables internacionales y su aplicación en el contexto chileno.',
                'category' => (object) ['name' => 'Contabilidad'],
                'published_at' => now()->subDays(15),
                'slug' => 'nuevos-estandares-contables-2025'
            ]
        ]);

        return view('public-site.home', compact('circulars'));
    }
}
