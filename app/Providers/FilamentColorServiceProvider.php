<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

class FilamentColorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
        public function boot(): void
    {
        // Registrar colores corporativos de CYC
        FilamentColor::register([
            'primary' => '#0A0A4D',      // Azul oscuro CYC
            'secondary' => '#1a1a6b',    // Azul más claro
            'accent' => '#E30613',       // Rojo CYC
            'success' => '#10B981',      // Verde profesional
            'warning' => '#F59E0B',      // Amarillo profesional
            'danger' => '#EF4444',       // Rojo profesional
            'info' => '#3B82F6',         // Azul profesional
        ]);
    }
}
