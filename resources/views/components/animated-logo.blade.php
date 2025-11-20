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
