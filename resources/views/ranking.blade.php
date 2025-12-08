{{--
/**
 * Vista: Ranking Global
 * 
 * Muestra el ranking de los mejores jugadores de Math League.
 * 
 * Funcionalidades:
 * - Ranking global de todos los juegos
 * - Filtros por juego específico (MathBus, Cortacésped, MathMatch)
 * - Top 10 jugadores con puntuaciones
 * - Destacado visual para el usuario actual
 * - Sistema de medallas para top 3
 * 
 * Visualización:
 * - Medallas oro, plata y bronce para top 3
 * - Destaque especial para el usuario actual
 * - Información de puntuación, nivel y tiempo
 * 
 * @extends layouts.app
 * @section content
 * 
 * @param int|null $idJuego ID del juego filtrado (null para todos)
 * @param Collection $ranking Datos del ranking
 * @param int|null $userId ID del usuario actual
 * 
 * @uses RankingController::index - Obtención de datos de ranking
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

    <!-- CONTENIDO DEL RANKING -->
    <div class="flex-1 max-w-6xl mx-auto p-6 w-full">

        <!-- Header del Ranking -->
        <div class="bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 text-white p-8 rounded-xl shadow-2xl mb-8">
            <h1 class="text-5xl font-bold text-center drop-shadow-lg font-lilita">
                🏆 RANKING GLOBAL 🏆
            </h1>
            <p class="text-center mt-2 text-lg opacity-90">Los mejores jugadores de Math League</p>
        </div>

        <!-- Filtros de Juego -->
        <div class="flex justify-center gap-4 mb-6 flex-wrap">
            <x-botones 
                text="TODOS" 
                href="{{ route('ranking') }}"
                color="{{ $idJuego === null ? '#1E40AF' : '#3B82F6' }}" 
                border_color="#1E40AF" 
                text_color="#FFFFFF" 
                size="md" 
                height="normal" />
            <x-botones 
                text="MATHBUS" 
                href="{{ route('ranking', ['juego' => 1]) }}"
                color="{{ $idJuego == 1 ? '#2563EB' : '#60A5FA' }}" 
                border_color="#2563EB" 
                text_color="#FFFFFF" 
                size="md" 
                height="normal" />
            <x-botones 
                text="CORTACÉSPED" 
                href="{{ route('ranking', ['juego' => 2]) }}"
                color="{{ $idJuego == 2 ? '#059669' : '#34D399' }}" 
                border_color="#059669" 
                text_color="#FFFFFF" 
                size="md" 
                height="normal" />
            <x-botones 
                text="MATHMATCH" 
                href="{{ route('ranking', ['juego' => 3]) }}"
                color="{{ $idJuego == 3 ? '#D97706' : '#F59E0B' }}" 
                border_color="#D97706" 
                text_color="#FFFFFF" 
                size="md" 
                height="normal" />
        </div>

        <!-- Tabla de Ranking -->
        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl overflow-hidden">
            
            <!-- Header de la tabla -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-4">
                <div class="grid grid-cols-12 gap-4 font-bold text-lg">
                    <div class="col-span-2 text-center">#</div>
                    <div class="col-span-6">Jugador</div>
                    <div class="col-span-4 text-center">Puntos</div>
                </div>
            </div>

            <!-- Contenido de la tabla -->
            <div class="divide-y divide-gray-200">
                @forelse($rankings as $rank)
                    <div class="grid grid-cols-12 gap-4 px-6 py-4 hover:bg-indigo-50 transition-colors duration-200 
                        {{ $rank['position'] <= 3 ? 'bg-gradient-to-r from-yellow-50 to-orange-50' : '' }}">
                        
                        <!-- Posición -->
                        <div class="col-span-2 text-center">
                            <span class="font-bold text-2xl {{ $rank['position'] <= 3 ? 'text-yellow-600' : 'text-gray-700' }}">
                                {{ $rank['medal'] ?: $rank['position'] }}
                            </span>
                        </div>

                        <!-- Jugador -->
                        <div class="col-span-6 flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-xl">
                                {{ strtoupper(substr($rank['username'], 0, 1)) }}
                            </div>
                            <span class="font-semibold text-gray-800 text-xl">{{ $rank['username'] }}</span>
                        </div>

                        <!-- Puntos -->
                        <div class="col-span-4 text-center flex items-center justify-center">
                            <span class="inline-block bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-2 rounded-full font-bold text-lg">
                                {{ number_format($rank['points']) }} pts
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-gray-500">
                        <p class="text-xl">No hay datos de ranking disponibles.</p>
                        <p class="mt-2">¡Sé el primero en jugar y aparecer en el ranking!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
