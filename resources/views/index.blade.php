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
<div class="min-h-screen w-full flex flex-col">

    <!-- NAVBAR -->
    <x-navbar bg_color="#111111" marginTop="mt-0" marginBottom="mb-0">
        <x-botones text="APRENDIZAJE" href="{{ route('aprendizaje') }}" color="transparent" border_color="transparent" text_color="#fff" size="lg" height="large"></x-botones>
        <x-botones text="JUEGOS" href="{{ route('juegos') }}" color="transparent" border_color="transparent" text_color="#fff" size="lg" height="large"></x-botones>
        <x-botones text="SOBRE NOSOTROS" href="{{ route('about') }}" color="transparent" border_color="transparent" text_color="#fff" size="lg" height="large"></x-botones>
        <x-botones text="PERFIL" href="{{ route('perfil') }}" color="transparent" border_color="transparent" text_color="#fff" size="lg" height="large"></x-botones>
    </x-navbar>

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
