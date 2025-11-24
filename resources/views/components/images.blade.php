@php
    $juegos = [
        ['fondos' => 'mathbus.png', 'ruta' => 'cortacesped'],
        ['fondos' => 'manolo.png', 'ruta' => 'mathbus'],
        ['fondos' => 'mathmatch.png', 'ruta' => 'mathmatch'],
        ['fondos' => 'mathentrevista.png', 'ruta' => 'entrevista'],
    ];
@endphp

<div class="flex flex-col gap-10 w-full py-10">
    @foreach (collect($juegos)->chunk(2) as $chunk)
        <div class="flex flex-wrap gap-10 justify-center items-center w-full">
            @foreach ($chunk as $juego)
                <a href="{{ route($juego['ruta']) }}" class="hover:opacity-80 hover:scale-105 transition-all duration-200 ease-in-out">
                    <img 
                        src="{{ asset('img/juegos/' . $juego['fondos']) }}" 
                        alt="{{ $juego['fondos'] }}" 
                        class="w-60 h-60 md:w-64 md:h-64 object-cover rounded-xl bg-gray-200"
                    />
                </a>
            @endforeach
        </div>
    @endforeach
</div>
