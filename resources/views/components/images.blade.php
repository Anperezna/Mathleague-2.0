@props(['juegosCompletados' => [],
         'juegos' => []])



<div class="flex flex-col gap-10 w-full py-10">
    @foreach (collect($juegos)->chunk(2) as $chunk)
        <div class="flex flex-wrap gap-10 justify-center items-center w-full">
            @foreach ($chunk as $juego)
                
    
                <div class="relative group">
                    @if($juego['idJuego'] == 1 || in_array($juego['idJuego'] - 1, $juegosCompletados))
                        <a href="{{ route($juego['ruta'], ['idJuego' => $juego['idJuego']]) }}" 
                           class="block hover:opacity-80 hover:scale-105 transition-all duration-200 ease-in-out">
                            <img 
                                src="{{ asset('img/juegos/' . $juego['fondos']) }}" 
                                alt="{{ $juego['fondos'] }}" 
                                class="w-60 h-60 md:w-64 md:h-64 object-cover rounded-xl bg-gray-200"
                            />
                        </a>
                    @else
                        <div class="relative cursor-not-allowed">   
                            <img 
                                src="{{ asset('img/juegos/' . $juego['fondos']) }}" 
                                alt="{{ $juego['fondos'] }}" 
                                class="w-60 h-60 md:w-64 md:h-64 object-cover rounded-xl bg-gray-200 opacity-50 grayscale"
                            />
                            <!-- Candado -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-800 drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C9.243 2 7 4.243 7 7v3H6c-1.103 0-2 .897-2 2v8c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-8c0-1.103-.897-2-2-2h-1V7c0-2.757-2.243-5-5-5zM9 7c0-1.654 1.346-3 3-3s3 1.346 3 3v3H9V7zm4 10.723V19h-2v-1.277c-.595-.346-1-.984-1-1.723 0-1.103.897-2 2-2s2 .897 2 2c0 .738-.405 1.376-1 1.723z"/>
                                </svg>
                            </div>
                            <!-- Tooltip -->
                            <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2 bg-black text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                Completa el juego anterior
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach
</div>
