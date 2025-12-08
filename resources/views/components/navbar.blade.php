{{--
/**
 * Componente: Barra de Navegación Principal
 * 
 * Barra de navegación global con enlaces a las secciones principales.
 * 
 * Props:
 * @param string $width Ancho del navbar (default: 'w-full')
 * @param string $height Altura del navbar (default: 'h-20')
 * @param string $bg_color Color de fondo (default: 'transparent')
 * @param string $marginTop Margen superior (default: 'mt-5')
 * @param string $marginBottom Margen inferior (default: 'mb-5')
 * 
 * Enlaces:
 * - RANKING: Vista de clasificación global
 * - JUEGOS: Selección de juegos
 * - SOBRE NOSOTROS: Información del equipo
 * - PERFIL: Perfil del usuario
 * 
 * @uses x-botones Componente de botón reutilizable
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
])

<nav class="flex items-center justify-between px-6 {{ $width }} {{ $height }} {{ $marginBottom }} {{ $marginTop }}" style="background-color: {{ $bg_color }};">
    <x-botones text="RANKING" href="{{ route('ranking') }}" color="transparent" border_color="transparent" text_color="#000" size="lg" height="large">
    </x-botones>
    <x-botones text="JUEGOS" href="{{ route('juegos') }}" color="transparent" border_color="transparent" text_color="#000" size="lg" height="large">
    </x-botones>
    <x-botones text="SOBRE NOSOTROS" href="{{ route('about') }}" color="transparent" border_color="transparent" text_color="#000" size="lg" height="large">
    </x-botones>
    <x-botones text="PERFIL" href="{{ route('perfil') }}" color="transparent" border_color="transparent" text_color="#000" size="lg" height="large">
    </x-botones>    
</nav>