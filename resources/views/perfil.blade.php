@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">

    <!-- Header del perfil -->
    <x-profile-header :username="session('username', 'Usuario')" />

    <h2 class="text-2xl font-bold mt-8 mb-4">Estadísticas</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">

        <!-- Juego 1: Autobús -->
        <x-game-stats-card 
            title="El Autobús"
            image="img/juegos/mathbus.png"
        />

        <!-- Juego 2: Paco y la Cortacésped -->
        <x-game-stats-card 
            title="Paco y la Cortacésped"
            image="img/juegos/manolo.png"
        />

        <!-- Juego 3: Partido de Fútbol -->
        <x-game-stats-card 
            title="Partido de Fútbol"
            image="img/juegos/mathmatch.png"
        />

        <!-- Juego 4: Entrevista Postpartido -->
        <x-game-stats-card 
            title="Entrevista Postpartido"
            image="img/juegos/mathentrevista.png"
        />

    </div>
</div>
@endsection
