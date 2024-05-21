@extends('plantillaAdmin')
@section('titulo', 'Inicio')
@section('contenido')

    {{-- Mostrar mensajes de éxito o error --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Vista para hacer un crud de puestos --}}
    <h1>Listado de puestos</h1>
    <table class="table table-striped" id="puestos">
        <tr>
            <th>Mercado</th>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Dar de baja / alta</th>
        </tr>
        {{-- bucle para recorrer los puestos pasados  --}}
        @forelse ($puestos as $puesto)
            <tr>
                <td>{{ $puesto->mercado->nombre }}</td>
                <td>{{ $puesto->nombre }}</td>
                <td>{{ $puesto->usuario->nombre }}</td>
                <td><a class="btn {{ $puesto->baja == 0 ? 'btn-danger' : 'btn-success' }}"
                        href="{{ route('baja.puestos', $puesto->Id_puesto) }}">{{ $puesto->baja == 0 ? 'DAR DE BAJA' : 'DAR DE ALTA' }}</a>
                </td>
            </tr>
        @empty
            <p>No se encontraron puestos</p>
        @endforelse
    </table>

    <h1>Añadir Puestos</h1>
    <form class="formularioPuestos" action="{{ route('anyadir.puestos') }}" method="post">
        @csrf
        <table class="table table-striped" id="anyadirUsuarios">
            <tr>
                <th>Mercado</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
            <tr>
                <td>
                    <select name="Id_mercado" class="form-control" required>
                        <option value="" disabled selected>Selecciona un mercado</option>
                        @foreach ($mercados as $mercado)
                            <option value="{{ $mercado->Id_mercado }}">{{ $mercado->nombre }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" name="nombre" class="form-control"
                        placeholder="Introduce el nombre del nuevo puesto" pattern="^[A-Za-z0-9' .-]+$" required></td>
                <td>
                    <select name="Id_usuario" class="form-control" required>
                        <option value="" disabled selected>Selecciona un usuario dueño del puesto</option>
                        @foreach ($usuarios as $usuario)
                            <option value="{{ $usuario->Id_usuario }}">{{ $usuario->nombre }}</option>
                        @endforeach
                    </select>
                </td>
                <td><button type="submit" class="btn btn-primary">Añadir Puesto</button></td>
            </tr>
        </table>
    </form>


@endsection
