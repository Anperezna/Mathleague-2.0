{{--
/**
 * Vista: Perfil de Usuario
 * 
 * Pantalla de perfil que muestra las estadísticas de juego del usuario.
 * 
 * Información mostrada:
 * - Nombre de usuario
 * - Botón de cierre de sesión
 * - Tarjetas de estadísticas por juego:
 *   * Partidas jugadas
 *   * Mejor tiempo
 *   * Aciertos
 *   * Errores
 * 
 * Componentes:
 * - x-navbar: Navegación
 * - x-profile-header: Cabecera de perfil
 * - x-game-stats-card: Tarjeta de estadísticas por juego
 * 
 * @extends layouts.app
 * @section content
 * 
 * @param array $juegos Estadísticas de todos los juegos
 * @param Usuario $usuario Información del usuario (opcional)
 * 
 * @uses UsuarioController::perfil - Obtención de estadísticas
 * 
 * @author Math League Team
 * @version 1.0.0
 */
--}}
@extends('layouts.app')

@section('content')
    <div class="min-h-screen w-full bg-[url('/img/fondo.png')] bg-cover bg-center flex flex-col">

        <!-- NAVBAR -->
        <x-navbar bg_color="transparent" marginTop="mt-0" marginBottom="mb-0" />

        <!-- CONTENIDO DEL PERFIL -->
        <div class="flex-1 max-w-5xl mx-auto p-6 w-full">

            <!-- Header del perfil con botón de logout -->
            <div class="flex justify-between items-center mb-4">
                <x-profile-header :username="session('username', 'Usuario')" />

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg shadow-lg transition-all duration-200 hover:scale-105">
                        🚪 Cerrar Sesión
                    </button>
                </form>
            </div>

            <h2 class="text-2xl font-bold mt-8 mb-4 text-white">Estadísticas</h2>

            <div class="flex gap-x-[5rem] justify-center">
                @forelse($juegos as $juego)
                    <x-game-stats-card :title="$juego['title']" :image="$juego['image']" :partidas="$juego['partidas']" :mejorTiempo="$juego['mejorTiempo']"
                        :aciertos="$juego['aciertos']" :errores="$juego['errores']" />
                @empty
                    <p class="text-white text-center">No hay estadísticas disponibles. ¡Juega para ver tus resultados!</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
