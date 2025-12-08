{{--
/**
 * Componente: Navegación de Juegos
 * 
 * Barra de navegación simple con el logo, usada dentro de los juegos.
 * 
 * Props:
 * @param string $width Ancho del navbar (default: 'w-full')
 * @param string $height Altura del navbar (default: 'h-20')
 * @param string $bg_color Color de fondo (default: 'transparent')
 * @param string $marginTop Margen superior (default: 'mt-5')
 * @param string $marginBottom Margen inferior (default: 'mb-5')
 * @param string $color Color del texto (default: 'black')
 * 
 * Características:
 * - Posición fija en la parte superior
 * - Solo muestra el logo de Math League
 * - Tamaño de logo: 180px de ancho
 * 
 * @author Math League Team
 * @version 1.0.0
 */
--}}
@props([
    'width' => 'w-full',
    'height' => 'h-20',
    'bg_color' => 'transparent',
    'marginTop' => 'mt-5',
    'marginBottom' => 'mb-5',
    'color' => 'black',
])

<nav class="fixed top-0 left-0 px-6 {{ $width }} {{ $height }} bg-[{{ $bg_color }} ] {{ $marginBottom }} {{ $marginTop }}" style="color: {{ $color }};">
    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-[180px]">
</nav>