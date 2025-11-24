@props([
    'title',
    'image',
    'partidas' => 0,
    'mejorTiempo' => '--:--',
    'aciertos' => 0,
    'errores' => 0
])

<div class="bg-white shadow-md rounded-xl overflow-hidden hover:shadow-xl transition">
    <div class="w-full h-40 overflow-hidden">
        <img src="{{ asset($image) }}" alt="{{ $title }}" class="object-cover w-full h-full">
    </div>
    <div class="p-4">
        <h3 class="text-xl font-semibold text-gray-800 mb-3">{{ $title }}</h3>
        <div class="space-y-2">
            <div class="flex justify-between text-sm text-gray-700 bg-gray-100 px-3 py-1 rounded-lg">
                <span class="font-medium">Partidas:</span>
                <span>{{ $partidas }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-700 bg-gray-100 px-3 py-1 rounded-lg">
                <span class="font-medium">Mejor tiempo:</span>
                <span>{{ $mejorTiempo }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-700 bg-gray-100 px-3 py-1 rounded-lg">
                <span class="font-medium">Aciertos:</span>
                <span>{{ $aciertos }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-700 bg-gray-100 px-3 py-1 rounded-lg">
                <span class="font-medium">Errores:</span>
                <span>{{ $errores }}</span>
            </div>
        </div>
    </div>
</div>
