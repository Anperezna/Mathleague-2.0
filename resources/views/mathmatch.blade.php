@extends('layouts.app')
@section('content')
    <div class="h-full w-full bg-[url('/img/Campo_MathMatch.png')] bg-cover bg-center flex flex-col relative overflow-hidden">

        <!-- Área de juego -->
        <div id="game-container" class="flex-1 flex flex-col items-center justify-between p-8 relative">
            <!-- Panel superior: Número actual y puntuación -->
            <div class="bg-white/90 rounded-xl shadow-2xl px-6 py-3 flex items-center gap-6 z-10">
                <div class="text-center">
                    <p class="text-xs font-semibold text-gray-600 uppercase">Número Actual</p>
                    <p id="current-number" class="text-3xl font-bold text-blue-600">64</p>
                </div>
                <div class="w-px h-12 bg-gray-300"></div>
                <div class="text-center">
                    <p class="text-xs font-semibold text-gray-600 uppercase">Puntuación</p>
                    <p id="score" class="text-3xl font-bold text-green-600">0</p>
                </div>
                <div class="w-px h-12 bg-gray-300"></div>
                <div class="text-center">
                    <p class="text-xs font-semibold text-gray-600 uppercase">Defensa</p>
                    <p id="defense-level" class="text-3xl font-bold text-purple-600">1/5</p>
                </div>
                <div class="w-px h-12 bg-gray-300"></div>
                <div class="text-center">
                    <p class="text-xs font-semibold text-gray-600 uppercase">Tiempo</p>
                    <p id="timer" class="text-3xl font-bold text-blue-600">60</p>
                </div>
            </div>

            <!-- Campo de defensas -->
            <div class="flex-1 flex items-center justify-center w-full max-w-6xl">
                <div id="defense-container" class="relative w-full h-full flex items-center justify-center">
                    <!-- Las defensas se generarán dinámicamente aquí -->
                </div>
            </div>

            <!-- Modal de Game Over -->
            <div id="game-over-modal" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50">
                <div class="bg-white rounded-2xl p-8 max-w-md w-full text-center shadow-2xl">
                    <h2 class="text-4xl font-bold text-red-600 mb-4">¡Juego Terminado!</h2>
                    <p id="game-over-reason" class="text-xl text-gray-700 mb-4">Respuesta incorrecta</p>
                    <p class="text-2xl mb-2">Puntuación Final: <span id="final-score" class="font-bold text-green-600">0</span></p>
                    <p class="text-lg text-gray-600 mb-6">Defensas superadas: <span id="defenses-passed" class="font-bold">0</span>/5</p>
                    <button onclick="restartGame()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg text-xl transition-all">
                        Jugar de Nuevo
                    </button>
                </div>
            </div>

            <!-- Modal de Gol -->
            <div id="goal-modal" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50">
                <div class="bg-white rounded-2xl p-8 max-w-md w-full text-center shadow-2xl">
                    <h2 class="text-5xl font-bold text-green-600 mb-4">⚽ ¡GOOOOL! ⚽</h2>
                    <p class="text-2xl mb-2">+50 puntos</p>
                    <p class="text-xl text-gray-600 mb-6">Puntuación: <span id="goal-score" class="font-bold text-green-600">0</span></p>
                    <button onclick="nextRound()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg text-xl transition-all">
                        Siguiente Ronda
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript del juego -->
    <script src="{{ asset('js/mathmatch.js') }}"></script>
@endsection