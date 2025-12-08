{{--
/**
 * Componente: Logo Animado
 * 
 * Logo principal de Math League con animación de respiración y efectos hover.
 * 
 * Props:
 * @param string $src Ruta de la imagen del logo (default: 'img/logo.png')
 * @param string $alt Texto alternativo del logo (default: 'Math League Logo')
 * 
 * Animaciones:
 * - logo-breathe: Animación de respiración (4s, infinite)
 * - Hover: Escala 1.05 y rotación de 5 grados
 * 
 * Diseño responsivo:
 * - Desktop: 450px de ancho
 * - Tablet (xl): 380px de ancho
 * - Móvil (md): 260px, centrado, reordenado
 * - Móvil pequeño (sm): 220px
 * 
 * @author Math League Team
 * @version 1.0.0
 */
--}}
@props(['src' => 'img/logo.png', 'alt' => 'Math League Logo'])

<div class="relative flex items-center justify-start flex-none w-[450px]
    max-xl:w-[380px]
    max-md:order-[-1] max-md:w-[260px] max-md:justify-center
    max-sm:w-[220px]">

    <img src="{{ asset($src) }}"
        class="relative z-[1] w-full h-auto animate-[logo-breathe_4s_ease-in-out_infinite]
        transition-transform duration-300 hover:scale-105 hover:rotate-[5deg] ml-12
        max-xl:ml-8 max-md:ml-0"
        alt="{{ $alt }}">
</div>
