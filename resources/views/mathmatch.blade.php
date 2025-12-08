{{--
/**
 * Vista: Juego MathMatch
 * 
 * Interfaz del juego "Partido de Fútbol" donde los jugadores factorizan
 * números primos para superar defensas y marcar goles mediante penaltis.
 * 
 * Mecánicas del juego:
 * - Factorización usando siempre el divisor más pequeño (primo)
 * - 5 defensas a superar por número
 * - Penalti al completar la factorización
 * - +1 punto por defensa, +5 puntos por gol
 * - Pierde si elige divisor incorrecto o portero para el tiro
 * 
 * Pantallas:
 * - Menú inicial con instrucciones
 * - Pantalla de juego con defensas
 * - Pantalla de penalti
 * - Modales de gol y game over
 * 
 * @extends layouts.app
 * @section content
 * 
 * @uses public/js/mathmatch.js - Lógica del juego
 * @uses MathmatchController - Gestión de sesiones
 * 
 * @author Math League Team
 * @version 1.0.0
 */
--}}
@extends('layouts.app')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="w-full min-h-screen flex justify-center items-center bg-gradient-to-b from-green-100 to-green-300">

        <div class="w-[1200px] h-[700px] relative">

            <!-- ========== MENÚ ========== -->
            <div id="menuScreen" class="absolute inset-0 flex flex-col justify-center items-center text-center space-y-6">
                <img src="{{ asset('img/juegos/mathmatch.png') }}" class="w-72 rounded-lg shadow-lg">

                <p class="text-lg">¡Factoriza el número y supera todas las defensas para marcar gol!</p>

                <button onclick="startGame()"
                    class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow">
                    Iniciar Juego
                </button>

                <div class="text-gray-700 space-y-1">
                    <p>⚽ Divide el número usando siempre el divisor más pequeño (primo)</p>
                    <p>🛡️ Supera 5 defensas eligiendo el divisor correcto en cada una</p>
                    <p>🎯 Completa la factorización para tirar el penalti</p>
                    <p>⏱️ El tiempo corre: ¡Completa 5 números para ganar!</p>
                    <p>💯 +1 punto por defensa superada, +5 puntos por gol marcado</p>
                    <p>❌ Pierdes si eliges un divisor incorrecto o el portero para tu tiro</p>
                </div>
            </div>

            <!-- ========== JUEGO ========== -->
            <div id="gameScreen" class="absolute inset-0 hidden">
                <div
                    class="fixed inset-0 w-screen h-screen bg-[url('/img/Campo_MathMatch.png')] bg-cover bg-center flex flex-col overflow-hidden">
                    <!-- Área de juego -->
                    <div id="game-container" class="flex-1 flex flex-col items-center justify-between p-8 relative">
                        <!-- Panel superior: Enunciado -->
                        <div class="bg-white/95 rounded-xl shadow-2xl px-8 py-4 mb-4 z-10 max-w-3xl w-full text-center">
                            <p id="enunciado" class="text-xl font-bold text-gray-800">Cargando pregunta...</p>
                        </div>

                        <!-- Panel de información: Número actual y puntuación -->
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
                                <p id="timer" class="text-3xl font-bold text-blue-600">40</p>
                            </div>
                        </div>

                        <!-- Campo de defensas -->
                        <div class="flex-1 flex items-center justify-center w-full max-w-6xl">
                            <div id="defense-container" class="relative w-full h-full flex items-center justify-center">
                                <!-- Las defensas se generarán dinámicamente aquí -->
                            </div>
                        </div>

                        <!-- Pantalla de Penalti -->
                        <div id="penalty-screen"
                            class="hidden fixed inset-0 bg-[url('/img/porteria_mathmatch.png')] bg-cover bg-center flex items-center justify-center z-50">
                            <div class="relative w-full h-full flex items-center justify-center">
                                <!-- Portero -->
                                <img id="goalkeeper" src="{{ asset('img/portero_mathmatch.png') }}" alt="Portero"
                                    class="absolute w-32 h-auto transition-all duration-300"
                                    style="bottom: 25%; left: 50%; transform: translateX(-50%); width: 550px;">

                                <!-- Botones de tiro (4 esquinas) -->
                                <button onclick="tirarPenalti('top-left')"
                                    class="absolute bg-yellow-400 hover:bg-yellow-500 text-black font-bold text-xl px-6 py-3 rounded-lg shadow-lg transition-all duration-200 hover:scale-110"
                                    style="top: 20%; left: 15%;">
                                    ¡CHUTA!
                                </button>
                                <button onclick="tirarPenalti('top-right')"
                                    class="absolute bg-yellow-400 hover:bg-yellow-500 text-black font-bold text-xl px-6 py-3 rounded-lg shadow-lg transition-all duration-200 hover:scale-110"
                                    style="top: 20%; right: 15%;">
                                    ¡CHUTA!
                                </button>
                                <button onclick="tirarPenalti('bottom-left')"
                                    class="absolute bg-yellow-400 hover:bg-yellow-500 text-black font-bold text-xl px-6 py-3 rounded-lg shadow-lg transition-all duration-200 hover:scale-110"
                                    style="bottom: 20%; left: 15%;">
                                    ¡CHUTA!
                                </button>
                                <button onclick="tirarPenalti('bottom-right')"
                                    class="absolute bg-yellow-400 hover:bg-yellow-500 text-black font-bold text-xl px-6 py-3 rounded-lg shadow-lg transition-all duration-200 hover:scale-110"
                                    style="bottom: 20%; right: 15%;">
                                    ¡CHUTA!
                                </button>
                            </div>
                        </div>

                        <!-- Modal de Gol -->
                        <div id="goal-modal" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50">
                            <div
                                class="bg-gradient-to-br from-green-400 to-green-600 rounded-2xl p-8 max-w-md w-full text-center shadow-2xl">
                                <h2 class="text-6xl font-bold text-white mb-4 drop-shadow-lg">⚽ ¡GOLAZO! ⚽</h2>
                                <p class="text-3xl font-bold text-yellow-300 mb-2 drop-shadow-md" id="goal-points">+5 puntos
                                </p>
                                <p class="text-xl text-white mb-4">Puntuación: <span id="goal-score"
                                        class="font-bold text-yellow-200">0</span></p>
                                <p class="text-lg text-white/90 animate-pulse">Siguiente número...</p>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <!-- ========== GAME OVER ========== -->
        <div id="game-over-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white p-8 rounded-xl text-center shadow-lg">
                <h2 class="text-3xl font-bold mb-4">¡Fin del Juego!</h2>
                <p id="game-over-reason" class="text-xl text-gray-700 mb-4">Respuesta incorrecta</p>
                <p class="text-xl mb-2">
                    Puntuación final:
                    <span id="final-score" class="font-bold text-green-600">0</span>
                </p>
                <p class="text-lg text-gray-600 mb-6">Tiempo jugado: <span id="final-time" class="font-bold">0</span>
                    segundos</p>

                <button onclick="reiniciarJuego()"
                    class="px-6 py-3 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
                    Volver a jugar
                </button>
                <button onclick="resetToMenu()"
                    class="ml-4 px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">

                    Volver al menú
                </button>
            </div>
        </div>

    </div>
    </div>

    <script>
        window.preguntas = @json($preguntas);
    </script>
    <script src="{{ asset('js/mathmatch.js') }}"></script>
@endsection
