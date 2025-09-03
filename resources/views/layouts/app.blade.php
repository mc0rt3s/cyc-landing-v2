<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    <!-- CSS compilado -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-0PkZ_gbb.css') }}">

    <!-- JavaScript compilado -->
    <script src="{{ asset('build/assets/app-C0G0cght.js') }}" defer></script>
</head>
<body class="bg-light text-gray-900 w-full">
<!-- Barra Superior -->
<div class="bg-white text-gray-700 border-b border-gray-200 shadow-sm w-full">
    <div class="flex justify-between items-center px-4 py-3 w-full">
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-2">
                <svg class="h-4 w-4 text-primary" fill="currentColor" viewBox="0 0 20 20"><path d="M2 5.5A3.5 3.5 0 0 1 5.5 2h9A3.5 3.5 0 0 1 18 5.5v9a3.5 3.5 0 0 1-3.5 3.5h-9A3.5 3.5 0 0 1 2 14.5v-9Z" /></svg>
                <a href="#ubicacion" class="text-base font-medium hover:text-primary transition-colors">Santiago, Chile</a>
            </div>
            <div class="flex items-center gap-2">
                <svg class="h-4 w-4 text-primary" fill="currentColor" viewBox="0 0 20 20"><path d="M2 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v.5L10 11 2 4.5V4Zm0 2.7V16a2 2 0 0 0 2 2h12a2 2 0 0 1 2-2V6.7l-8 6.4-8-6.4Z" /></svg>
                <span class="text-base font-medium">consultora@cycisla.cl</span>
            </div>
        </div>
        <div class="hidden sm:block">
            <span class="text-base font-semibold text-primary">+56 2 2798 2200</span>
        </div>
    </div>
</div>

<!-- Encabezado -->
<header class="bg-primary text-white shadow-sm border-b border-white/10 w-full">
    <div class="flex items-center justify-between px-4 py-3 md:py-5">
        <!-- Logo -->
        <a href="/" class="flex items-center space-x-3">
            <img src="{{ asset('images/logo-cyc.png') }}" alt="C&C Isla" class="h-14 w-auto md:h-16">
        </a>

        <!-- Navegación -->
        <nav class="hidden md:flex items-center space-x-4">
            <a href="#servicios" class="px-4 py-2 border border-white text-white rounded-md hover:bg-accent hover:border-accent hover:text-white transition">Servicios</a>
            <a href="#circulars" class="px-4 py-2 border border-white text-white rounded-md hover:bg-accent hover:border-accent hover:text-white transition">Circulares</a>
            <a href="mailto:consultora@cycisla.cl" class="px-4 py-2 border border-white text-white rounded-md hover:bg-accent hover:border-accent hover:text-white transition">Contacto</a>

            <a href="/intranet" class="px-4 py-2 border border-white text-white rounded-md hover:bg-accent hover:border-accent hover:text-white transition">
                Intranet
            </a>
        </nav>
    </div>
</header>

<!-- Contenido principal -->
<main class="bg-white text-primary w-full">
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-primary text-white text-center py-6 shadow-inner border-t border-white/10 w-full">
    <div class="px-4">
        <p>&copy; {{ date('Y') }} C&C Isla y Cía. Ltda. Todos los derechos reservados.</p>
    </div>
</footer>
</body>
</html>
