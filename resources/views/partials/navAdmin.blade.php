<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
    <li class="nav-item">
    <a class="nav-link" href="{{ route('logout') }}">Inicio</a>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.index') }}">Listado clientes</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.usuarios') }}">Listado usuarios</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.puestos') }}">Listado puestos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.mercados') }}">Listado mercados</a>
    </li>
    </ul>
    </div>
    </nav>