{{--
/**
 * Vista: Selección de Juegos
 * 
 * Pantalla de selección que muestra todos los juegos disponibles
 * con su estado de desbloqueo basado en progreso del usuario.
 * 
 * Implementa sistema de desbloqueo progresivo:
 * - Los juegos se desbloquean al completar el anterior
 * - Visualiza juegos completados y disponibles
 * 
 * Componentes utilizados:
 * - x-navbar: Barra de navegación
 * - x-botones: Botones de navegación
 * - x-images: Galería de juegos con estado
 * 
 * @extends layouts.app
 * @section content
 * 
 * @param array $juegosCompletados IDs de juegos completados
 * @param array $juegos Lista de juegos disponibles
 * 
 * @uses JuegosController - Gestión de juegos y progreso
 * 
 * @author Math League Team
 * @version 1.0.0
 */
--}}
@extends('layouts.app')

@section('content')
    <div class="min-h-screen w-full bg-[url('/img/fondo.png')] bg-cover bg-center flex flex-col">
        <x-navbar>
        <x-botones></x-botones>
        </x-navbar>
        <x-images :juegosCompletados="$juegosCompletados ?? []" :juegos="$juegos ?? []"></x-images>
    </div>
@endsection