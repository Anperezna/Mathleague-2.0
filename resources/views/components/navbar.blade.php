@props([
    'width' => 'w-full',
    'height' => 'h-20',
    'bg_color' => 'transparent',
    'marginTop' => 'mt-5',
    'marginBottom' => 'mb-5',
])

<nav class="flex items-center justify-between px-6 {{ $width }} {{ $height }} {{ $marginBottom }} {{ $marginTop }}" style="background-color: {{ $bg_color }};">
    <x-botones text="RANKING" href="{{ route('ranking') }}" color="transparent" border_color="transparent" text_color="#fff" size="lg" height="large">
    </x-botones>
    <x-botones text="JUEGOS" href="{{ route('juegos') }}" color="transparent" border_color="transparent" text_color="#fff" size="lg" height="large">
    </x-botones>
    <x-botones text="SOBRE NOSOTROS" href="{{ route('about') }}" color="transparent" border_color="transparent" text_color="#fff" size="lg" height="large">
    </x-botones>
    <x-botones text="PERFIL" href="{{ route('perfil') }}" color="transparent" border_color="transparent" text_color="#fff" size="lg" height="large">
    </x-botones>    
</nav>