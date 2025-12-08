{{--
/**
 * Vista: Acerca de Nosotros
 * 
 * Muestra información sobre el equipo de desarrollo de Math League.
 * Presenta tres tarjetas de perfil con información de los desarrolladores:
 * - Albert Canovas (Frontend)
 * - Ángel Pérez (Frontend)
 * - Dani (Frontend)
 * 
 * @extends layouts.app
 * @section content
 * 
 * @author Math League Team
 * @version 1.0.0
 */
--}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full bg-[url('/img/fondo.png')] bg-cover bg-center flex flex-col">
    
    <!-- NAVBAR -->
    <x-navbar bg_color="transparent" marginTop="mt-0" marginBottom="mb-0" />

    <!-- CONTENIDO DEL ABOUT -->
    <div class="flex-1 max-w-7xl mx-auto p-6 w-full">

        <!-- Cards de Perfiles -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            
            <!-- Card Albert -->
            <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-purple-500/50">
                <div class="bg-gradient-to-br from-blue-500 to-purple-600 p-6 text-center">
                    <div class="w-40 h-40 mx-auto rounded-full border-4 border-white shadow-xl overflow-hidden mb-4">
                        <img src="{{ asset('img/albert.jpg') }}" alt="Albert Canovas" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-2xl font-bold text-white drop-shadow-lg">Albert Canovas</h3>
                    <p class="text-blue-100 font-semibold mt-1">Desarrollador Frontend</p>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 text-center leading-relaxed">
                        Organizado y orientado a resultados, garantiza que cada proyecto se ejecute con precisión, tiempo y calidad.
                    </p>
                </div>
            </div>

            <!-- Card Ángel -->
            <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-pink-500/50">
                <div class="bg-gradient-to-br from-pink-500 to-red-600 p-6 text-center">
                    <div class="w-40 h-40 mx-auto rounded-full border-4 border-white shadow-xl overflow-hidden mb-4">
                        <img src="{{ asset('img/personal/angel.png') }}" alt="Ángel Pérez" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-2xl font-bold text-white drop-shadow-lg">Ángel Pérez</h3>
                    <p class="text-pink-100 font-semibold mt-1">Desarrollador Frontend</p>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 text-center leading-relaxed">
                        Apasionado por el diseño y la innovación, lidera cada proyecto con una visión única que combina estética y funcionalidad.
                    </p>
                </div>
            </div>

            <!-- Card Dani -->
            <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-green-500/50">
                <div class="bg-gradient-to-br from-green-500 to-teal-600 p-6 text-center">
                    <div class="w-40 h-40 mx-auto rounded-full border-4 border-white shadow-xl overflow-hidden mb-4">
                        <img src="{{ asset('img/dani.jpg') }}" alt="Dani Barrufet" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-2xl font-bold text-white drop-shadow-lg">Dani Barrufet</h3>
                    <p class="text-green-100 font-semibold mt-1">Desarrollador Frontend</p>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 text-center leading-relaxed">
                        Especialista en tecnología y programación, convierte ideas en experiencias digitales eficientes y atractivas.
                    </p>
                </div>
            </div>

        </div>

        <!-- Footer Info -->
        <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-xl p-6 text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-3">🎮 Math League 2.0</h2>
            <p class="text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Proyecto educativo diseñado para hacer las matemáticas más divertidas y accesibles a través de juegos interactivos. 
                Nuestro objetivo es ayudar a estudiantes a mejorar sus habilidades matemáticas mientras se divierten.
            </p>
            <div class="flex justify-center gap-4 mt-4 text-sm text-gray-500">
                <span>📅 2024-2025</span>
                <span>•</span>
                <span>🏫 Proyecto Educativo</span>
                <span>•</span>
                <span>💻 Laravel + Tailwind CSS</span>
            </div>
        </div>

    </div>
</div>
@endsection