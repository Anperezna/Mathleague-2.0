{{--
/**
 * Componente: Texto de Presentación Principal
 * 
 * Narrativa de bienvenida que explica la historia y concepto de Math League.
 * 
 * Contenido:
 * - Título principal "Math League" con fuente Lilita One
 * - Tres párrafos narrativos explicando la temática del juego:
 *   1. Presentación del concepto (matemáticas + fútbol)
 *   2. Descripción de las etapas del juego
 *   3. Llamada a la acción
 * - Botón de acción "Jugar Ahora"
 * 
 * Estilos destacados:
 * - Título con sombras y efectos 3D
 * - Texto blanco con sombras para legibilidad sobre fondo
 * - Diseño totalmente responsivo
 * - Gradientes y efectos hover en botón
 * 
 * @uses x-primary-button Botón de acción principal
 * 
 * @author Math League Team
 * @version 1.0.0
 */
--}}
<div class="flex-[1.5] max-md:max-w-full">

    <!-- HERO TITLE -->
    <h1 class="font-lilita text-[4.2rem] font-normal text-[#ee3b1b] mb-6 leading-none uppercase tracking-[2px]
        drop-shadow-[3px_3px_0_rgba(0,0,0,0.2)] shadow-xl
        max-xl:text-[3.7rem]
        max-md:text-center max-md:text-[2.8rem]
        max-sm:text-[2.2rem]">
        Math League
    </h1>

    <!-- STORY PARAGRAPHS -->
    <p class="text-white text-[1.2rem] mb-3 leading-[1.6] text-justify font-medium
        drop-shadow-[2px_2px_4px_rgba(0,0,0,0.5)]
        max-xl:text-[1.15rem] max-md:text-left max-md:text-[1rem] max-sm:text-[0.95rem]">
        Bienvenido a Math League, donde las matemáticas y el fútbol se unen en una
        experiencia única. Como entrenador, vivirás un día de partido completo resolviendo
        operaciones matemáticas en cada etapa.
    </p>

    <p class="text-white text-[1.2rem] mb-3 leading-[1.6] text-justify font-medium
        drop-shadow-[2px_2px_4px_rgba(0,0,0,0.5)]
        max-xl:text-[1.15rem] max-md:text-left max-md:text-[1rem] max-sm:text-[0.95rem]">
        Recogerás a tus jugadores en el autobús identificando sus números de camiseta
        mediante cálculos. Ayudarás a Paco a preparar el campo con la cortacésped siguiendo
        patrones matemáticos. Jugarás el partido donde cada jugada depende de resolver
        operaciones bajo presión. Y finalmente, responderás a la prensa analizando las
        estadísticas del encuentro.
    </p>

    <p class="text-white text-[1.2rem] mb-3 leading-[1.6] text-justify font-medium
        drop-shadow-[2px_2px_4px_rgba(0,0,0,0.5)]
        max-xl:text-[1.15rem] max-md:text-left max-md:text-[1rem] max-sm:text-[0.95rem]">
        ¿Estás listo para liderar al Math League? La liga donde los números ganan partidos te espera.
    </p>

    <!-- PRIMARY BUTTON 
    <a href="{{ route('register') }}"
        class="inline-block mt-5 px-14 py-3.5 rounded-full text-white text-[1.35rem] font-bold uppercase tracking-wide
        bg-gradient-to-br from-[#ee3b1b] to-[#ee3b1b]
        shadow-[0_6px_20px_rgba(230,57,70,0.4),0_3px_6px_rgba(0,0,0,0.3)]
        transition-all duration-300 font-lilita
        hover:from-[#f4626e] hover:to-[#e63946]
        hover:-translate-y-1
        hover:shadow-[0_8px_25px_rgba(230,57,70,0.5),0_5px_10px_rgba(0,0,0,0.4)]
        max-md:w-full max-md:text-center max-md:text-[1.15rem]
        max-sm:px-8 max-sm:text-[1.05rem]">
        ¡Comenzar!
    </a>
    -->

</div>
