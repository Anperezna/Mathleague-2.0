{{--
/**
 * Componente: Botón Reutilizable
 * 
 * Componente genérico para botones y enlaces con estilos personalizables.
 * 
 * Props:
 * @param string $color Color de fondo (default: 'blue')
 * @param string $text Texto del botón (default: '')
 * @param string $size Tamaño: 'sm', 'md', 'lg' (default: 'md')
 * @param string $type Tipo de botón HTML (default: 'button')
 * @param string|null $href URL para enlace (null = botón, string = enlace)
 * @param string|null $img Ruta de imagen/icono opcional
 * @param string $height Altura: 'small', 'normal', 'large', 'xlarge' (default: 'normal')
 * @param string $border_color Color del borde (default: 'black')
 * @param string $text_color Color del texto (default: '#FFFFFF')
 * @param string $onclick Atributo onclick para JavaScript (default: '')
 * @param string $text_size Tamaño del texto (default: 'text-[25px]')
 * 
 * Comportamiento:
 * - Si $href existe: renderiza un enlace <a>
 * - Si $href es null: renderiza un botón <button>
 * - Incluye efectos hover de brillo y escala
 * 
 * @author Math League Team
 * @version 1.0.0
 */
--}}
@props([
    'color' => 'blue',
    'text' => '',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'img' => null,
    'height' => 'normal',
    'border_color' => 'black',
    'text_color' => '#FFFFFF',
    'onclick' => '',
    'text_size' => 'text-[25px]',
])

@if ($href)
    <a href="{{ $href }}"
        class="flex items-center gap-2 bg-[{{ $color }}] border-2 border-[{{ $border_color }}] hover:brightness-75 hover:scale-95 text-[{{ $text_color }}] 
        font-medium rounded-lg px-{{ $size == 'sm' ? '3' : ($size == 'lg' ? '6' : '5') }} py-{{ $height == 'small' ? '2' : ($height == 'large' ? '6' : 
        ($height == 'xlarge' ? '8' : '3')) }} {{ $text_size }} {{ $text_color }} transition-all duration-200 inline-block text-center">
        @if ($img)
            <img src="{{ asset($img) }}" alt="icon" class="w-5 h-5">
        @endif
        {{ $text }}
    </a>
@else
    <button type="{{ $type }}" @if ($onclick) onclick="{{ $onclick }}" @endif
        class="flex items-center gap-2 bg-[{{ $color }}] border-2 border-[{{ $border_color }}] hover:brightness-75 hover:scale-95 text-[{{ $text_color }}] font-medium rounded-lg px-{{ $size == 'sm' ? '3' : ($size == 'lg' ? '6' : '5') }} py-{{ $height == 'small' ? '2' : ($height == 'large' ? '6' : ($height == 'xlarge' ? '8' : '3')) }} text-{{ $size }} transition-all duration-200">
        @if ($img)
            <img src="{{ asset($img) }}" alt="icon" class="w-5 h-5">
        @endif
        {{ $text }}
    </button>
@endif
