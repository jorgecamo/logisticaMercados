<html>
    <head>
        <title>
            @yield('titulo')
        </title>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])  
        <!-- api de googlemaps para generar la mejor ruta de reparto  -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCeU5HhFh_mm0jgzYGdz_SOLw4ZbB0oW5o&libraries=places"></script>

        <!-- Incluir CSS de Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Incluir jQuery (si aún no está incluido) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Incluir JS de Select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>   
       </head>
        <body>
            @include('partials.navConserje')
            @yield('contenido')
    </body>
</html>