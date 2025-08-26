<!-- resources/views/public-site/home.blade.php -->
@extends('layouts.app')

@section('content')
        <!-- Hero Section Mejorado -->
    <section class="relative bg-gray-900 text-white w-full min-h-screen flex items-center">
        <img src="{{ asset('images/Sala1600x500.png') }}" class="absolute inset-0 h-full w-full object-cover opacity-90" />

        <!-- Overlay muy suave para apreciar la imagen -->
        <div class="absolute inset-0 bg-gradient-to-r from-primary/30 to-primary/20"></div>

        <div class="relative z-10 flex flex-col items-center justify-center text-center px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
            <img src="{{ asset('images/LogoLetrasBlancas.png') }}" alt="C&C Isla y Cía." class="h-28 md:h-36 mb-8 drop-shadow-2xl animate-fade-in" />

            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                <span class="block">Más de 50 años</span>
                <span class="block text-accent">de confianza</span>
            </h1>

            <p class="text-xl md:text-2xl font-medium mb-8 max-w-3xl leading-relaxed">
                Desde 1972 acompañando a nuestros clientes con soluciones contables, tributarias y laborales de excelencia.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 sm:gap-6">
                <a href="#servicios" class="inline-flex items-center justify-center px-8 py-4 bg-accent text-white font-semibold rounded-lg shadow-lg hover:bg-red-700 transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Conoce Nuestros Servicios
                </a>

                <a href="mailto:consultora@cycisla.cl" class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-primary transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Contáctanos
                </a>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <!-- Estadísticas de Confianza -->
    <section class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="space-y-2">
                    <div class="text-4xl md:text-5xl font-bold text-primary">50+</div>
                    <div class="text-sm md:text-base text-gray-600">Años de Experiencia</div>
                </div>
                <div class="space-y-2">
                    <div class="text-4xl md:text-5xl font-bold text-primary">500+</div>
                    <div class="text-sm md:text-base text-gray-600">Clientes Satisfechos</div>
                </div>
                <div class="space-y-2">
                    <div class="text-4xl md:text-5xl font-bold text-primary">24/7</div>
                    <div class="text-sm md:text-base text-gray-600">Soporte Disponible</div>
                </div>
                <div class="space-y-2">
                    <div class="text-4xl md:text-5xl font-bold text-primary">100%</div>
                    <div class="text-sm md:text-base text-gray-600">Compromiso</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Servicios Mejorados -->
    <section id="servicios" class="bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-primary mb-4">Nuestros Servicios</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Soluciones integrales para la gestión financiera de tu empresa con la experiencia de más de 50 años en el mercado.</p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                <!-- Contabilidad -->
                <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border-t-4 border-accent">
                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-4">Contabilidad</h3>
                    <p class="text-gray-600 leading-relaxed">Registro, control y análisis de la información financiera con enfoque estratégico para la toma de decisiones.</p>
                </div>

                <!-- Tributario -->
                <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border-t-4 border-accent">
                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-4">Tributario</h3>
                    <p class="text-gray-600 leading-relaxed">Asesoría y cumplimiento de obligaciones fiscales con planificación tributaria optimizada.</p>
                </div>

                <!-- Laboral -->
                <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border-t-4 border-accent">
                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-5-4M9 20h6M4 20h5v-2a4 4 0 00-5-4m5-4a3 3 0 1 0-6 0 3 3 0 0 0 6 0Zm12 0a3 3 0 1 0-6 0 3 3 0 0 0 6 0Z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-4">Laboral</h3>
                    <p class="text-gray-600 leading-relaxed">Gestión y asesoría en temas laborales, contratos, remuneraciones y cumplimiento normativo.</p>
                </div>

                <!-- Auditorías -->
                <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border-t-4 border-accent">
                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-4">Auditorías</h3>
                    <p class="text-gray-600 leading-relaxed">Revisión detallada para asegurar la integridad financiera y el cumplimiento normativo de tu empresa.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Circulares Mejoradas -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-primary mb-4">Últimas Circulares</h2>
                <p class="text-xl text-gray-600">Mantente informado con las últimas novedades tributarias y contables</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @if(isset($circulars) && count($circulars) > 0)
                    @foreach ($circulars as $circular)
                        <div class="bg-white border border-gray-200 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-accent/10 text-accent">
                                        {{ $circular->category ? $circular->category->name : 'General' }}
                                    </span>
                                    <span class="text-sm text-gray-500">{{ $circular->published_at ? $circular->published_at->format('d/m/Y') : 'Próximamente' }}</span>
                                </div>

                                <h3 class="text-xl font-bold text-primary mb-3 group-hover:text-accent transition-colors">{{ $circular->title }}</h3>
                                <p class="text-gray-600 mb-4 line-clamp-3">{!! $circular->summary !!}</p>

                                <a href="#" class="inline-flex items-center text-accent font-semibold hover:underline group-hover:text-primary transition-colors">
                                    Leer más
                                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Circular de ejemplo cuando no hay datos -->
                    <div class="bg-white border border-gray-200 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-accent/10 text-accent">
                                    Tributario
                                </span>
                                <span class="text-sm text-gray-500">Próximamente</span>
                            </div>

                            <h3 class="text-xl font-bold text-primary mb-3 group-hover:text-accent transition-colors">Nuevas disposiciones tributarias 2025</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">Información sobre los cambios en la normativa tributaria para el año 2025 y sus implicaciones para las empresas.</p>

                            <a href="#" class="inline-flex items-center text-accent font-semibold hover:underline group-hover:text-primary transition-colors">
                                Leer más
                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Otra circular de ejemplo -->
                    <div class="bg-white border border-gray-200 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-accent/10 text-accent">
                                    Laboral
                                </span>
                                <span class="text-sm text-gray-500">Próximamente</span>
                            </div>

                            <h3 class="text-xl font-bold text-primary mb-3 group-hover:text-accent transition-colors">Actualización de salarios mínimos</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">Nuevos montos de salarios mínimos vigentes desde enero de 2025 y su impacto en la planilla de remuneraciones.</p>

                            <a href="#" class="inline-flex items-center text-accent font-semibold hover:underline group-hover:text-primary transition-colors">
                                Leer más
                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Tercera circular de ejemplo -->
                    <div class="bg-white border border-gray-200 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-accent/10 text-accent">
                                    Contabilidad
                                </span>
                                <span class="text-sm text-gray-500">Próximamente</span>
                            </div>

                            <h3 class="text-xl font-bold text-primary mb-3 group-hover:text-accent transition-colors">Nuevos estándares contables</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">Actualización de los estándares contables internacionales y su aplicación en el contexto chileno.</p>

                            <a href="#" class="inline-flex items-center text-accent font-semibold hover:underline group-hover:text-primary transition-colors">
                                Leer más
                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <div class="text-center mt-12">
                <a href="#" class="inline-flex items-center px-8 py-4 bg-primary text-white font-semibold rounded-lg hover:bg-primary/90 transition-colors">
                    Ver todas las circulares
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-primary py-20">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">¿Listo para optimizar tu gestión financiera?</h2>
            <p class="text-xl text-gray-200 mb-8">Únete a más de 500 empresas que confían en nuestra experiencia</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="mailto:consultora@cycisla.cl" class="inline-flex items-center justify-center px-8 py-4 bg-accent text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Solicita una Consulta Gratuita
                </a>
                <a href="tel:+56227982200" class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-primary transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Llámanos
                </a>
            </div>
        </div>
    </section>

    <!-- Ubicación Mejorada -->
    <section id="ubicacion" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-primary mb-4">Nuestra Oficina</h2>
            </div>

            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <div class="bg-white rounded-xl p-8 shadow-lg">
                        <h3 class="text-2xl font-bold text-primary mb-4">Información de Contacto</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-accent mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-900">Dirección</p>
                                    <p class="text-gray-600">Av. Apoquindo 6275, Oficina 21<br>Las Condes, Santiago, Chile</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-accent mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-900">Teléfono</p>
                                    <p class="text-gray-600">+56 2 2798 2200</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-accent mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-900">Email</p>
                                    <p class="text-gray-600">consultora@cycisla.cl</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl overflow-hidden shadow-lg">
                    <iframe
                        class="w-full h-96"
                        loading="lazy"
                        allowfullscreen
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3330.566687328924!2d-70.56772802378619!3d-33.408467273406124!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662cedd07f65dc1%3A0x39444fdb0a945840!2sC%20y%20C%20Isla%20y%20Compa%C3%B1%C3%ADa!5e0!3m2!1ses!2scl!4v1745350422667!5m2!1ses!2scl"
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                </div>
            </div>
        </div>
    </section>
@endsection
