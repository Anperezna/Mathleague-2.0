@extends('layouts.app')

@section('content')
<div class="w-full h-screen flex justify-center items-center bg-gradient-to-b from-blue-100 to-blue-300">

    <div class="w-[900px] h-[600px] relative">

        <!-- ========== MENÚ ========== -->
        <div id="menuScreen" class="absolute inset-0 flex flex-col justify-center items-center text-center space-y-6">
            <img src="{{ asset('img/juegos/mathbus.png') }}" class="w-72 rounded-lg shadow-lg">

            <p class="text-lg">¡Mueve el bus con las flechas ↑ ↓ para recoger las respuestas correctas!</p>

            <button onclick="game.start()" 
                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow">
                <p></p>    Iniciar Juego
            </button>

            <div class="text-gray-700 space-y-1">
                <p>📝 Usa las teclas ↑ y ↓ para mover el bus</p>
                <p>🎯 Recoge la respuesta correcta</p>
                <p>❌ El juego termina después de 3 fallos</p>
                <p>❌ Si dejas pasar una respuesta correcta también es fallo</p>
            </div>
        </div>

        <!-- ========== JUEGO ========== -->

        <x-navbarjuegos></x-navbarjuegos>
        <div id="gameScreen" class="absolute inset-0 hidden">

            <!-- Header -->
            <div class="flex justify-between items-center p-4 bg-white shadow rounded">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('img/mathbus/mathbus_game.png') }}" class="h-12">
                    
                </div>

                <div id="operationDisplay" class="text-2xl font-bold text-blue-700">
                    Cargando...
                </div>

                <div class="flex space-x-6 text-xl">
                    <div>Puntos: <span id="score" class="font-bold text-green-600">0</span></div>
                    <div>Fallos: <span id="missed" class="font-bold text-red-600">0</span>/3</div>
                </div>
            </div>

            <!-- Área del juego -->
            <div id="gameArea" class="relative h-[500px] bg-blue-200 overflow-hidden rounded-lg mt-4">

                <!-- Bus -->
                <div id="bus" class="absolute left-4 top-1/2 -translate-y-1/2 w-24">
                    <img src="{{ asset('img/mathbus/mathbus_game.png') }}" class="w-full">
                </div>

                <!-- Carretera -->
                <div class="absolute bottom-0 w-full h-12 bg-gray-700"></div>

            </div>
        </div>

        <!-- ========== GAME OVER ========== -->
        <div id="gameOverModal" 
            class="hidden absolute inset-0 bg-black bg-opacity-50 flex justify-center items-center">

            <div class="bg-white p-8 rounded-xl text-center shadow-lg">
                <h2 class="text-3xl font-bold mb-4">¡Fin del Juego!</h2>
                <p class="text-xl mb-6">
                    Puntuación final: 
                    <span id="finalScore" class="font-bold text-blue-600">0</span>
                </p>

                <button onclick="game.reset()" class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                    Volver al menú
                </button>
            </div>

        </div>

    </div>
</div>

<script src="{{ asset('js/mathbus.js') }}"></script>
@endsection
