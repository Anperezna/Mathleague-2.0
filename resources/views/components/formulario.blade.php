{{--
/**
 * Componente: Formulario Dinámico
 * 
 * Componente que renderiza formularios de login o registro basado en la ruta actual.
 * 
 * Props:
 * @param string $flexDirection Dirección flex (default: 'flex-col')
 * @param string $alignItems Alineación de items (default: 'items-start')
 * @param string $justifyContent Justificación de contenido (default: 'justify-start')
 * @param string $width Ancho del formulario (default: 'w-[450px]')
 * @param string $height Altura del formulario (default: 'h-auto')
 * @param string $bg_color Color de fondo con blur (default: 'bg-white/70 backdrop-blur-lg')
 * @param string $border_color Color del borde (default: 'border-white/30')
 * @param string $text_size Tamaño del texto del título (default: 'text-[32px]')
 * 
 * Formularios:
 * - Login: username, contraseña, confirmación
 * - Registro: username, email, contraseña, confirmación
 * 
 * Validaciones:
 * - Todos los campos requeridos
 * - Validación de email en registro
 * - Confirmación de contraseña
 * 
 * @uses x-input Componente de input reutilizable
 * @uses x-botones Componente de botón
 * 
 * @author Math League Team
 * @version 1.0.0
 */
--}}
@props([
    'flexDirection' => 'flex-col',
    'alignItems' => 'items-start',
    'justifyContent' => 'justify-start',
    'width' => 'w-[450px]',
    'height' => 'h-auto',
    'bg_color' => 'bg-white/70 backdrop-blur-lg',
    'border_color' => 'border-white/30',
    'text_size' => 'text-[32px]',
])


@if (request()->routeIs('login'))
    {{-- Formulario de login --}}
    <form action="{{ route('login.submit') }}" method="POST" class="flex {{ $flexDirection }} {{ $alignItems }} {{ $justifyContent }} {{ $width }} {{ $height }} {{ $bg_color }} {{ $border_color }} border-2 p-8 rounded-2xl shadow-2xl">
    @csrf
    <h1 class="{{ $text_size }} font-bold text-gray-800 mb-2">Iniciar Sesión</h1>
    <p class="text-gray-600 mb-6 text-sm">Accede a tu cuenta de Math League</p>
    
    <label class="mb-2 font-semibold text-gray-700">Nombre de usuario:</label>
    <x-input name="username" type="text" required></x-input>
    
    <label class="mb-2 mt-4 font-semibold text-gray-700">Contraseña:</label>
    <x-input name="contrasena" type="password" required></x-input>
    
    <label class="mb-2 mt-4 font-semibold text-gray-700">Confirmar contraseña:</label>
    <x-input name="contrasena_confirmation" type="password" required></x-input>
    
    <div class="w-full flex justify-center mt-6">
        <x-botones text="Entrar" type="submit" color="#4CAF50" border_color="#388E3C" text_color="#FFFFFF" size="lg" height="medium" text_size="text-[20px]" class="transform transition-all duration-200 hover:scale-105">
        </x-botones>
    </div>
    
    <p class="text-center text-gray-600 mt-4 text-sm">
        ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-green-600 hover:text-green-700 font-semibold underline">Regístrate aquí</a>
    </p>
</form>
@elseif (request()->routeIs('register'))
    {{-- Formulario de registro --}}
    <form action="{{ route('register.submit') }}" method="POST" class="flex {{ $flexDirection }} {{ $alignItems }} {{ $justifyContent }} {{ $width }} {{ $height }} {{ $bg_color }} {{ $border_color }} border-2 p-8 rounded-2xl shadow-2xl">
    @csrf
    <h1 class="{{ $text_size }} font-bold text-gray-800 mb-2">Crear Cuenta</h1>
    <p class="text-gray-600 mb-6 text-sm">Únete a Math League y comienza a jugar</p>
    
    <label class="mb-2 font-semibold text-gray-700">Nombre de usuario:</label>
    <x-input name="username" type="text" required></x-input>
    
    <label class="mb-2 mt-4 font-semibold text-gray-700">Correo electrónico:</label>
    <x-input name="email" type="email" required></x-input>
    
    <label class="mb-2 mt-4 font-semibold text-gray-700">Contraseña:</label>
    <x-input name="contrasena" type="password" required></x-input>
    
    <label class="mb-2 mt-4 font-semibold text-gray-700">Verificar contraseña:</label>
    <x-input name="contrasena_confirmation" type="password" required></x-input>
    
    <div class="w-full flex justify-center mt-6"> 
        <x-botones text="Registrarse" type="submit" color="#4CAF50" border_color="#388E3C" text_color="#FFFFFF" size="lg" height="medium" text_size="text-[20px]" class="transform transition-all duration-200 hover:scale-105">
        </x-botones>
    </div>
    
    <p class="text-center text-gray-600 mt-4 text-sm">
        ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-semibold underline">Inicia sesión aquí</a>
    </p>
</form> 
@endif
