@props([
    'width' => 'w-full',
    'height' => 'h-20',
    'bg_color' => 'transparent',
    'marginTop' => 'mt-5',
    'marginBottom' => 'mb-5',
])

<nav class="flex items-left justify-between px-6 {{ $width }} {{ $height }} bg-[{{ $bg_color }} ] {{ $marginBottom }} {{ $marginTop }}">
    <img src="img/logo.png" alt="">
</nav>