{{--
/**
 * Componente: Cabecera de Perfil
 * 
 * Muestra el nombre de usuario en la página de perfil.
 * 
 * Props:
 * @param string $username Nombre del usuario (default: 'Usuario')
 * 
 * Estilos:
 * - Texto blanco con sombra para legibilidad
 * - Tamaño grande (3xl) y negrita
 * - Fondo transparente para superposición
 * 
 * @author Math League Team
 * @version 1.0.0
 */
--}}
@props(['username' => 'Usuario'])

<div class="bg-transparent text-white p-6 rounded-xl">
    <h1 class="text-3xl font-bold drop-shadow-lg">
        {{ $username }}
    </h1>
</div>
