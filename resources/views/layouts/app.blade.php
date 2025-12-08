{{--
/**
 * Layout: Aplicación Principal
 * 
 * Plantilla base para todas las vistas de Math League.
 * 
 * Configuración:
 * - Meta tags para responsividad y CSRF
 * - Fuente personalizada Lilita One de Google Fonts
 * - TailwindCSS CDN con configuración personalizada
 * - Stack de estilos personalizados
 * 
 * Variables:
 * @param string $title Título de la página (default: 'Math League')
 * 
 * Secciones:
 * @yield content - Contenido principal de cada vista
 * @stack styles - Estilos adicionales personalizados
 * 
 * @author Math League Team
 * @version 1.0.0
 */
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Math League' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'lilita': ['"Lilita One"', 'cursive'],
                    },
                },
            },
        };
    </script>

    @stack('styles')
</head>

<body class="overflow-x-hidden">
    @yield('content')
    @stack('scripts')
</body>

</html>
