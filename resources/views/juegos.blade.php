@extends('layouts.app')

@section('content')
    <div class="min-h-screen w-full bg-[url('/img/fondo.png')] bg-cover bg-center flex flex-col">
        <x-navbar>
        <x-botones></x-botones>
        </x-navbar>
        <x-images :juegosCompletados="$juegosCompletados ?? []" :juegos="$juegos ?? []"></x-images>
    </div>
@endsection