@props([
    'flexDirection' => 'flex-col',
    'alignItems' => 'items-start',
    'justifyContent' => 'justify-start',
    'width' => 'w-[400px]',
    'height' => 'h-auto',
    'bg_color' => 'bg-white',
    'border_color' => 'border-transparent',
    'text_size' => 'text-[27px]',
])


@if (request()->routeIs('login'))
    {{-- Formulario de login --}}
    <form action="{{ route('login.submit') }}" method="POST" class="flex {{ $flexDirection }} {{ $alignItems }} {{ $justifyContent }} {{ $width }} {{ $height }} {{ $bg_color }} {{ $border_color }} p-6 rounded-lg shadow">
    @csrf
    <h1 class="{{ $text_size }}">Login</h1>
    <br>
    <label class="mb-2 font-semibold text-lg">Nombre de usuario:</label>
    <x-input name="username" type="text" required></x-input>
    <label class="mb-2 mt-4 font-semibold text-lg">Contraseña:</label>
    <x-input name="contrasena" type="password" required></x-input>
    <label class="mb-2 mt-4 font-semibold text-lg">Confirmar contraseña:</label>
    <x-input name="contrasena_confirmation" type="password" required></x-input>
    <br>
    <br>
    <div class="w-full flex justify-center">
        <x-botones text="Login" type="submit" color="#4CAF50" border_color="#388E3C" text_color="#FFFFFF" size="lg" height="medium" text_size="text-[20px]" class="mt-6">
        </x-botones>
    </div>
</form>
@elseif (request()->routeIs('register'))
    {{-- Formulario de registro --}}
    <form action="{{ route('register.submit') }}" method="POST" class="flex {{ $flexDirection }} {{ $alignItems }} {{ $justifyContent }} {{ $width }} {{ $height }} {{ $bg_color }} {{ $border_color }} p-6 rounded-lg shadow">
    @csrf
    <h1 class="{{ $text_size }}">Register</h1>
    <br>
    <label class="mb-2 font-semibold text-lg">Nombre de usuario:</label>
    <x-input name="username" type="text" required></x-input>
    <label class="mb-2 mt-4 font-semibold text-lg">Correo electrónico:</label>
    <x-input name="email" type="email" required></x-input>
    <label class="mb-2 mt-4 font-semibold text-lg">Contraseña:</label>
    <x-input name="contrasena" type="password" required></x-input>
    <label class="mb-2 mt-4 font-semibold text-lg">Verificar contraseña:</label>
    <x-input name="contrasena_confirmation" type="password" required></x-input>
    <br>
    <div class="w-full flex justify-center"> 
        <x-botones text="Registrarse" type="submit" color="#4CAF50" border_color="#388E3C" text_color="#FFFFFF" size="lg" height="medium" text_size="text-[20px]" class="mt-6">
        </x-botones>
    </div>
</form> 
@endif
