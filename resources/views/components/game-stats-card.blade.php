@props([
    'title',
    'image',
    'partidas' => 0,
    'mejorTiempo' => '--:--',
    'aciertos' => 0,
    'errores' => 0,
    'width' => '250px',
])

<div class="bg-white shadow-2xl rounded-2xl overflow-hidden hover:shadow-[0_20px_60px_rgba(0,0,0,0.3)] hover:scale-105 transition-all duration-300 border-4 border-transparent hover:border-[#ee3b1b]" style="width: {{ $width }};">
    <div class="w-full h-48 overflow-hidden relative">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/20"></div>
        <img src="{{ asset($image) }}" alt="{{ $title }}" class="object-cover w-full h-full transform hover:scale-110 transition-transform duration-500">
    </div>
    <div class="p-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-4 border-b-2 border-[#ee3b1b] pb-2">{{ $title }}</h3>
        <div class="space-y-3">
            <!-- Primera fila: Partidas y Mejor tiempo -->
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col items-center text-sm text-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 px-4 py-2.5 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <span class="font-semibold text-gray-800">Partidas</span>
                    <span class="font-bold text-[#ee3b1b] text-lg mt-1">{{ $partidas }}</span>
                </div>
                <div class="flex flex-col items-center text-sm text-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 px-4 py-2.5 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <span class="font-semibold text-gray-800">Mejor tiempo</span>
                    <span class="font-bold text-[#ee3b1b] text-lg mt-1">{{ $mejorTiempo }}</span>
                </div>
            </div>
            
            <!-- Segunda fila: Aciertos y Errores -->
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col items-center text-sm text-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 px-4 py-2.5 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <span class="font-semibold text-gray-800">Aciertos</span>
                    <span class="font-bold text-green-600 text-lg mt-1">{{ $aciertos }}</span>
                </div>
                <div class="flex flex-col items-center text-sm text-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 px-4 py-2.5 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <span class="font-semibold text-gray-800">Errores</span>
                    <span class="font-bold text-red-600 text-lg mt-1">{{ $errores }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
