{{--
/**
 * Vista: Página Principal
 * 
 * Página de inicio de Math League que muestra la narrativa del juego
 * y el logo animado principal.
 * 
 * Elementos:
 * - Navbar transparente
 * - Componente de texto narrativo (x-texto-index)
 * - Logo animado con efectos de respiración (x-animated-logo)
 * 
 * Estilos personalizados:
 * - Animación glow-pulse para efectos de brillo
 * - Animación logo-breathe para efecto de respiración del logo
 * 
 * @extends layouts.app
 * @section content
 * @push styles
 * 
 * @author Math League Team
 * @version 1.0.0
 */
--}}
@extends('layouts.app')

@push('styles')
    <style>
        @keyframes glow-pulse {

            0%,
            100% {
                opacity: .5;
                transform: scale(1);
            }

            50% {
                opacity: .8;
                transform: scale(1.1);
            }
        }

        @keyframes logo-breathe {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.03);
            }
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen w-full bg-[url('/img/fondo.png')] bg-cover bg-center flex flex-col">
        
        <!-- NAVBAR -->
        <x-navbar bg_color="transparent" marginTop="mt-0" marginBottom="mb-0" />

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex justify-center items-center">
            <div class="flex gap-20 justify-center items-center w-full max-w-[110rem] px-16
                max-xl:gap-16 max-xl:px-12
                max-md:flex-col max-md:gap-8 max-md:px-6 max-md:py-10">

                <!-- STORY TEXT -->
                <x-texto-index />

                <!-- LOGO -->
                <x-animated-logo />

            </div>
        </div>
    </div>
@endsection
