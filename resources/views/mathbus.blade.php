{{--
/**
 * Vista: Juego MathBus
 * 
 * Interfaz del juego "El Autobús" donde los jugadores controlan un autobús
 * para recoger las respuestas correctas a operaciones matemáticas.
 * 
 * Mecánicas del juego:
 * - Control vertical del autobús con flechas ↑ ↓
 * - Recoger respuestas correctas que se desplazan
 * - Máximo 3 fallos permitidos
 * - Dejar pasar una respuesta correcta también cuenta como fallo
 * - Sistema de puntos por respuestas acertadas
 * 
 * Pantallas:
 * - Menú inicial con instrucciones
 * - Pantalla de juego con área dinámica
 * - Modal de game over
 * 
 * @extends layouts.app
 * @section content
 * 
 * @param Collection $preguntas Preguntas matemáticas del juego
 * 
 * @uses public/js/mathbus.js - Lógica del juego
 * @uses PreguntasController::mathbus - Carga de preguntas
 * 
 * @author Math League Team
 * @version 1.0.0
 */
--}}
@extends('layouts.app')

@section('content')
    <div class="w-full min-h-screen flex justify-center items-center bg-gradient-to-b from-blue-100 to-blue-300">

        <div class="w-[1200px] h-[700px] relative">

            <!-- ========== MENÚ ========== -->
            <div id="menuScreen" class="absolute inset-0 flex flex-col justify-center items-center text-center space-y-6">
                <img src="{{ asset('img/juegos/mathbus.png') }}" class="w-72 rounded-lg shadow-lg">

                <p class="text-lg">¡Mueve el bus con las flechas ↑ ↓ para recoger las respuestas correctas!</p>

                <button onclick="game.inicio()"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow">
                    <p></p> Iniciar Juego
                </button>

                <div class="text-gray-700 space-y-1">
                    <p>📝 Usa las teclas ↑ y ↓ para mover el bus</p>
                    <p>🎯 Recoge la respuesta correcta</p>
                    <p>❌ El juego termina después de 3 fallos</p>
                    <p>❌ Si dejas pasar una respuesta correcta también es fallo</p>
                </div>
            </div>

            <!-- ========== JUEGO ========== -->

            <div id="gameScreen" class="absolute inset-0 hidden">
                <x-navbarjuegos></x-navbarjuegos>

                <!-- Header -->
                <div class="flex justify-between items-center p-4 bg-white shadow rounded">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('img/mathbus/mathbus_game.png') }}" class="h-12">

                    </div>

                    <div id="operationDisplay" class="text-2xl font-bold text-blue-700">
                        @if ($preguntas->count())
                                <div>{{ $preguntas[0]->enunciado }}</div>
                            @endif
                    </div>

                    <div class="flex space-x-6 text-xl">
                        <div>Puntos: <span id="puntos" class="font-bold text-green-600">0</span></div>
                        <div>Fallos: <span id="fallos" class="font-bold text-red-600">0</span>/3</div>
                    </div>
                    <button onclick="game.usarAyuda()"
                        class="px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-white font-bold rounded-lg shadow">
                        Ayuda
                    </button>
                </div>

                <!-- Área del juego -->
                <div id="gameArea" class="relative h-[500px] bg-blue-200 overflow-hidden rounded-lg mt-4 bg-[url('/img/mathbus/fondo_mathbus.png')] bg-repeat-x">

                    <!-- Bus -->
                    <div id="bus" class="absolute left-4 w-24" style="top:150px;">
                        <img src="{{ asset('img/mathbus/mathbus_game.png') }}" class="w-full">
                    </div>

                    <!-- Carretera -->
                    <div class="absolute bottom-0 w-full h-12 bg-gray-700"></div>

                </div>
            </div>

            <!-- ========== GAME OVER ========== -->
            <div id="gameOverModal" class="hidden absolute inset-0 bg-black bg-opacity-50 flex justify-center items-center">

                <div class="bg-white p-6 rounded-xl text-center shadow-lg max-w-md">
                    <h2 class="text-2xl font-bold mb-4 text-gray-800">¡Fin del Juego!</h2>
                    
                    <div class="space-y-3 mb-6 text-left">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Puntos:</span>
                            <span id="finalPuntos" class="font-bold text-green-600">0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Tiempo:</span>
                            <span id="finalTiempo" class="font-bold text-blue-600">0s</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Errores:</span>
                            <span id="finalErrores" class="font-bold text-red-600">0</span>
                        </div>
                    </div>

                    <button onclick="window.location.href='/juegos'"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 w-full">
                        Cerrar
                    </button>
                </div>

            </div>

        </div>
    </div>

    <script>
        window.preguntas = @json($preguntas);
    </script>
    <script src="{{ asset('js/mathbus.js') }}"></script>
@endsection
