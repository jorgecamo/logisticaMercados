<html>
    <head>
        <title>
            @yield('titulo')
        </title>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])     
       </head>
        <body>
            @yield('contenido')
    </body>
</html>