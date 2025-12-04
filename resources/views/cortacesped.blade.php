@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cortacésped - MathLeague</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #000;
        }
        canvas {
            display: block;
            background: #000;
        }
    </style>
</head>
<body>
    <script src="{{ asset('js/cortacesped.js') }}"></script>
</body>
</html>
@endsection
