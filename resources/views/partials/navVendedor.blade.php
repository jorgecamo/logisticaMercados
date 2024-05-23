<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <img src="{{ asset('images/logotipo.png') }}" alt="Logotipo" style="width: 130px; height: 50px;">

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav  ml-auto">
                <li class="nav-item active me-4">
                    <a class="nav-link fs-5" href="{{ route('logout') }}">Inicio</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link fs-5" href="#">Crear pedido</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
