<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
    <li class="nav-item">
    <a class="nav-link" href="{{ route('logout') }}">Inicio</a>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('conserje.index') }}">Lista pedidos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('conserje.clientes') }}">Añadir clientes</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('conserje.direcciones') }}">Añadir direcciones</a>
    </li>
    </ul>
    </div>
    </nav>