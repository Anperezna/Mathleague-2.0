{{--
/**
 * Componente: Campo de Entrada
 * 
 * Input HTML reutilizable con estilos consistentes y validación.
 * 
 * Props:
 * @param string $width Ancho del input (default: 'w-full')
 * @param string $type Tipo de input HTML (default: 'text')
 * @param string $name Nombre del campo para formulario (default: '')
 * @param bool $required Si el campo es obligatorio (default: false)
 * @param string $value Valor predeterminado del campo (default: '')
 * 
 * Características:
 * - Mantiene valores anteriores con helper old()
 * - Focus ring azul para accesibilidad
 * - Bordes negros con estilo consistente
 * - Padding interno para mejor UX
 * 
 * @author Math League Team
 * @version 1.0.0
 */
--}}
@props([
    'width' => 'w-full',
    'type' => 'text',
    'name' => '',
    'required' => false,
    'value' => '',
])

<input 
    type="{{ $type }}" 
    name="{{ $name }}"
    value="{{ old($name, $value) }}"
    {{ $required ? 'required' : '' }}
    class="border-2 border-black rounded-lg px-4 py-2 {{ $width }} focus:outline-none focus:ring-2 focus:ring-blue-500"
>