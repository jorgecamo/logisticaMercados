<html>
    <head>
        <title>
            @yield('titulo')
        </title>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])     
       </head>
        <body>
            @include('partials.navAdmin')
            @yield('contenido')
    </body>
</html>