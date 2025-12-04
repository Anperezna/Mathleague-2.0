@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cortacésped - MathLeague</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #000;
        }
        canvas {
            display: block;
            background: #000;
        }

        /* Modal de estadísticas */
        #gameOverModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            max-width: 500px;
            width: 90%;
            text-align: center;
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-title {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #FFD700;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.5);
        }

        .modal-subtitle {
            font-size: 24px;
            color: white;
            margin-bottom: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        .stat-label {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: bold;
            color: white;
        }

        .stat-value.green {
            color: #4ade80;
        }

        .stat-value.red {
            color: #f87171;
        }

        .stat-value.yellow {
            color: #FFD700;
        }

        .reason-text {
            font-size: 18px;
            color: #FFD700;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .modal-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .modal-btn {
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-retry {
            background: #4ade80;
            color: white;
        }

        .btn-retry:hover {
            background: #22c55e;
            transform: scale(1.05);
        }

        .btn-menu {
            background: white;
            color: #667eea;
        }

        .btn-menu:hover {
            background: #f3f4f6;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <!-- Modal de Game Over -->
    <div id="gameOverModal">
        <div class="modal-content">
            <h1 class="modal-title" id="modalTitle">¡GANASTE!</h1>
            <p class="modal-subtitle">ESTADÍSTICAS DEL JUEGO</p>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Aciertos</div>
                    <div class="stat-value green" id="modalAciertos">0/6</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Tiempo</div>
                    <div class="stat-value" id="modalTime">0s</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Errores</div>
                    <div class="stat-value red" id="modalErrores">0/3</div>
                </div>
                <div class="stat-card" style="grid-column: span 2;">
                    <div class="stat-label">Césped Cortado</div>
                    <div class="stat-value green" id="modalCesped">0%</div>
                </div>
            </div>

            <p class="reason-text" id="reasonText"></p>

            <div class="modal-buttons">
                <button class="modal-btn btn-retry" onclick="location.reload()">
                    🔄 Jugar de nuevo
                </button>
                <button class="modal-btn btn-menu" onclick="window.location.href='{{ route('juegos') }}'">
                    🏠 Menú principal
                </button>
            </div>
        </div>
    </div>

    <script>
        // Inyectar preguntas desde la base de datos
        window.preguntasDB = @json($preguntas);
    </script>
    <script src="{{ asset('js/cortacesped.js') }}"></script>
</body>
</html>
@endsection
