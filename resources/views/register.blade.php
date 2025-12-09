{{--
/**
 * Vista: Registro de Usuarios
 * 
 * Pantalla de registro para nuevos usuarios de Math League.
 * 
 * Funcionalidad:
 * - Formulario de registro con validación
 * - Creación de nueva cuenta de usuario
 * - Redirección automática tras registro exitoso
 * 
 * Componentes:
 * - x-formulario: Componente de formulario reutilizable
 * 
 * @extends layouts.app
 * @section content
 * 
 * @uses RegisterController - Procesamiento de registro
 * 
 * @author Math League Team
 * @version 1.0.0
 */
--}}
@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center align-center min-h-screen bg-[url('https://anperezna.tech/public/img/fondo.png')] bg-cover bg-center">
        <x-formulario>
        </x-formulario>
    </div>
@endsection    
