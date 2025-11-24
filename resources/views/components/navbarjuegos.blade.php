@props([
    'width' => 'w-full',
    'height' => 'h-20',
    'bg_color' => 'transparent',
    'marginTop' => 'mt-5',
    'marginBottom' => 'mb-5',
])

<nav class="fixed top-0 left-0 px-6 {{ $width }} {{ $height }} bg-[{{ $bg_color }} ] {{ $marginBottom }} {{ $marginTop }}">
    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-[180px]">
</nav>