@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="w-full min-h-screen flex justify-center items-center bg-gradient-to-b from-green-100 to-green-300">

    <div class="w-full h-screen relative">

        <!-- ========== MENÚ ========== -->
        <div id="menuScreen" class="absolute inset-0 flex flex-col justify-center items-center text-center space-y-6">
            <img src="{{ asset('img/juegos/manolo.png') }}" class="w-72 rounded-lg shadow-lg">

            <p class="text-lg">¡Ayuda a Paco a cortar el césped resolviendo operaciones matemáticas!</p>

            <button onclick="iniciarJuego()" 
                class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow">
                Iniciar Juego
            </button>

            <div class="text-gray-700 space-y-1">
                <p>🎮 Usa las flechas ← → ↑ ↓ para mover a Paco</p>
                <p>🧮 Recoge el bidón con la respuesta correcta</p>
                <p>✂️ Corta todo el césped para ganar</p>
                <p>⏱️ Tienes 60 segundos</p>
                <p>❌ Máximo 3 errores permitidos</p>
                <p>🎯 Necesitas 6 aciertos para completar</p>
            </div>
        </div>

        <!-- ========== JUEGO ========== -->
        <div id="gameScreen" class="absolute inset-0 hidden overflow-hidden">
            <div id="canvasContainer" class="w-full h-full"></div>
        </div>

        <!-- ========== GAME OVER ========== -->
        <div id="game-over-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white p-8 rounded-xl text-center shadow-lg max-w-md">
                <h2 class="text-3xl font-bold mb-4" id="modal-title">¡Fin del Juego!</h2>
                <p id="game-over-reason" class="text-xl text-gray-700 mb-4">Resultado del juego</p>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Aciertos:</span>
                        <span id="final-aciertos" class="font-bold text-green-600">0/6</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Tiempo:</span>
                        <span id="final-tiempo" class="font-bold text-blue-600">0s</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Errores:</span>
                        <span id="final-errores" class="font-bold text-red-600">0/3</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Césped Cortado:</span>
                        <span id="final-cesped" class="font-bold text-green-600">0%</span>
                    </div>
                </div>

                <div class="flex gap-3 justify-center">
                    <button onclick="reiniciarJuego()" class="px-6 py-3 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
                        Volver a jugar
                    </button>
                    <button onclick="volverMenu()" class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                        Volver al menú
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="{{ asset('js/cortacesped.js') }}"></script>
<script>
function iniciarJuego() {
    document.getElementById('menuScreen').classList.add('hidden');
    document.getElementById('gameScreen').classList.remove('hidden');
    // Crear la instancia del juego cuando se inicia
    if (typeof CortacespedGame !== 'undefined') {
        gameInstance = new CortacespedGame();
        gameInstance.startGame();
    }
}

function reiniciarJuego() {
    location.reload();
}

function volverMenu() {
    window.location.href = '{{ route('juegos') }}';
}
</script>
@endsection
