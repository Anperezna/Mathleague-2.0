{{--
/**
 * Componente: Botón Principal
 * 
 * Botón de acción principal con estilo destacado y efectos visuales.
 * 
 * Props:
 * @param string $href URL de destino del enlace
 * @param string $text Texto a mostrar en el botón
 * 
 * Características visuales:
 * - Gradiente rojo (#ee3b1b) con efecto degradado
 * - Sombras múltiples para profundidad
 * - Fuente Lilita One en mayúsculas
 * - Bordes redondeados (rounded-full)
 * 
 * Efectos hover:
 * - Cambio de gradiente a tonos más claros
 * - Elevación con translate-y
 * - Intensificación de sombras
 * 
 * Responsividad:
 * - Ancho completo en móvil
 * - Ajuste de padding y tamaño de texto
 * 
 * @author Math League Team
 * @version 1.0.0
 */
--}}
@props(['href', 'text'])

<a href="{{ $href }}"
    class="inline-block mt-5 px-14 py-3.5 rounded-full text-white text-[1.35rem] font-bold uppercase tracking-wide
    bg-gradient-to-br from-[#ee3b1b] to-[#ee3b1b]
    shadow-[0_6px_20px_rgba(230,57,70,0.4),0_3px_6px_rgba(0,0,0,0.3)]
    transition-all duration-300 font-lilita
    hover:from-[#f4626e] hover:to-[#e63946]
    hover:-translate-y-1
    hover:shadow-[0_8px_25px_rgba(230,57,70,0.5),0_5px_10px_rgba(0,0,0,0.4)]
    max-md:w-full max-md:text-center max-md:text-[1.15rem]
    max-sm:px-8 max-sm:text-[1.05rem]">
    {{ $text }}
</a>
