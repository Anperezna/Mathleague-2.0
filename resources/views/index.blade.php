@extends('layouts.app')

@push('styles')
<style>
@keyframes glow-pulse {
    0%, 100% { opacity: .5; transform: scale(1);}
    50% { opacity: .8; transform: scale(1.1);}
}

@keyframes logo-breathe {
    0%, 100% { transform: scale(1);}
    50% { transform: scale(1.03);}
}
</style>
@endpush

@section('content')
<div class="min-h-screen w-full flex justify-center items-center">

    <div class="flex gap-20 justify-center items-center w-full max-w-[110rem] px-16
        max-xl:gap-16 max-xl:px-12
        max-md:flex-col max-md:gap-8 max-md:px-6 max-md:py-10">

        <!-- STORY TEXT -->
        <div class="flex-[1.5] max-md:max-w-full">

            <x-hero-title text="Math League" />

            <x-story-paragraph>
                Bienvenido a Math League, donde las matemáticas y el fútbol se unen en una
                experiencia única. Como entrenador, vivirás un día de partido completo resolviendo
                operaciones matemáticas en cada etapa.
            </x-story-paragraph>

            <x-story-paragraph>
                Recogerás a tus jugadores en el autobús identificando sus números de camiseta
                mediante cálculos. Ayudarás a Paco a preparar el campo con la cortacésped siguiendo
                patrones matemáticos. Jugarás el partido donde cada jugada depende de resolver
                operaciones bajo presión. Y finalmente, responderás a la prensa analizando las
                estadísticas del encuentro.
            </x-story-paragraph>

            <x-story-paragraph>
                ¿Estás listo para liderar al Math League? La liga donde los números ganan partidos te espera.
            </x-story-paragraph>

            <x-primary-button href="{{ route('juegos') }}" text="¡Comenzar!" />

        </div>

        <!-- LOGO -->
        <x-animated-logo />

    </div>

</div>
@endsection
