@extends('layouts.app')

@section('content')
    <div class="h-full w-full bg-[url('/img/fondo.png')] bg-cover bg-center flex flex-col">
        <x-navbar bg_color="#111111">
        <x-botones></x-botones>
        </x-navbar>
        <x-images :juegosCompletados="$juegosCompletados ?? []" :juegos="$juegos ?? []"></x-images>
    </div>
@endsection