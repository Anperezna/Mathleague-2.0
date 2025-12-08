{{--
/**
 * Vista: Inicio de Sesión
 * 
 * Pantalla de autenticación de usuarios registrados en Math League.
 * 
 * Funcionalidad:
 * - Formulario de login con validación
 * - Redirección tras autenticación exitosa
 * - Mensajes de error de credenciales
 * 
 * Componentes:
 * - x-formulario: Componente de formulario reutilizable
 * 
 * @extends layouts.app
 * @section content
 * 
 * @uses LoginController - Procesamiento de autenticación
 * 
 * @author Math League Team
 * @version 1.0.0
 */
--}}
@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center align-center min-h-screen bg-[url('/img/fondo.png')] bg-cover bg-center">
        <x-formulario>
        </x-formulario>
    </div>
@endsection    