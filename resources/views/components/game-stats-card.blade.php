{{--
/**
 * Componente: Tarjeta de Estadísticas de Juego
 * 
 * Muestra las estadísticas de un juego específico del usuario.
 * 
 * Props:
 * @param string $title Nombre del juego
 * @param string $image Ruta de la imagen del juego
 * @param int $partidas Número de partidas jugadas (default: 0)
 * @param string $mejorTiempo Mejor tiempo en formato MM:SS (default: '--:--')
 * @param int $aciertos Total de aciertos (default: 0)
 * @param int $errores Total de errores (default: 0)
 * @param string $width Ancho de la tarjeta (default: '550px')
 * 
 * Estadísticas mostradas:
 * - Partidas: Color rojo (#ee3b1b)
 * - Mejor tiempo: Color rojo (#ee3b1b)
 * - Aciertos: Color verde (green-600)
 * - Errores: Color rojo (red-600)
 * 
 * Efectos visuales:
 * - Hover con sombra expandida
 * - Escala al pasar el ratón
 * - Borde animado en color rojo
 * - Zoom en imagen
 * 
 * @author Math League Team
 * @version 1.0.0
 */
--}}
@props([
    'title',
    'image',
    'partidas' => 0,
    'mejorTiempo' => '--:--',
    'aciertos' => 0,
    'errores' => 0,
    'width' => '550px',
])

@php
    $stats = [
        ['label' => 'Partidas', 'value' => $partidas, 'color' => 'text-[#ee3b1b]'],
        ['label' => 'Mejor tiempo', 'value' => $mejorTiempo, 'color' => 'text-[#ee3b1b]'],
        ['label' => 'Aciertos', 'value' => $aciertos, 'color' => 'text-green-600'],
        ['label' => 'Errores', 'value' => $errores, 'color' => 'text-red-600'],
    ];
@endphp

<div class="bg-white shadow-2xl rounded-2xl overflow-hidden hover:shadow-[0_20px_60px_rgba(0,0,0,0.3)] hover:scale-105 transition-all duration-300 border-4 border-transparent hover:border-[#ee3b1b]" style="width: {{ $width }};">
    <div class="w-full h-48 overflow-hidden relative">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/20"></div>
        <img src="{{ asset($image) }}" alt="{{ $title }}" class="object-cover w-full h-full transform hover:scale-110 transition-transform duration-500">
    </div>
    <div class="p-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-4 border-b-2 border-[#ee3b1b] pb-2">{{ $title }}</h3>
        <div class="grid grid-cols-2 gap-3">
            @foreach($stats as $stat)
                <div class="flex flex-col items-center text-sm text-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 px-4 py-2.5 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <span class="font-semibold text-gray-800">{{ $stat['label'] }}</span>
                    <span class="font-bold {{ $stat['color'] }} text-lg mt-1">{{ $stat['value'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
