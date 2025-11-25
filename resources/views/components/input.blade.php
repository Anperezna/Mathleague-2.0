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