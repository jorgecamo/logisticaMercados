@extends('plantillaAdmin')
@section('titulo', 'Inicio')
@section('contenido')
    {{-- Vista para hacer un crud de usuarios --}}
    <h1>Listado de usuarios</h1>
    <table class="table table-striped" id="usuarios">
        <tr>
            <th>DNI</th>
            <th>Nombre</th>
            <th>Rol</th>
            <th>Telefono</th>
            <th>Contraseña</th>
            <th>Mercado</th>
            <th>Dar de baja / alta</th>
        </tr>
        {{-- bucle para recorrer los usuarios pasados  --}}
        @forelse ($usuarios as $usuario)
            {{-- if para que salgan todos los usuarios menos los del rol administrador --}}
            @if ($usuario->rol->Id_rol != 2)
                <tr>
                    <td>{{ $usuario->DNI }}</td>
                    <td>{{ $usuario->nombre }}</td>
                    <td>{{ $usuario->rol->rol }}</td>
                    <td>{{ $usuario->telefono }}</td>
                    <td>{{ $usuario->mercado->nombre }}</td>
                    <td>{{ $usuario->contrasenya }}</td>
                    <td><a class="btn {{ $usuario->baja == 0 ? 'btn-danger' : 'btn-success' }}"
                            href="{{ route('baja.usuarios', $usuario->Id_usuario) }}">{{ $usuario->baja == 0 ? 'DAR DE BAJA' : 'DAR DE ALTA' }}</a>
                    </td>
                </tr>
            @endif
        @empty
            <p>No se encontraron usuarios</p>
        @endforelse
    </table>

    <h1>Añadir usuarios</h1>
    <form class="formularioPedido" action="{{ route('anyadir.usuarios') }}" method="post">
        @csrf
        <table class="table table-striped" id="anyadirUsuarios">
            <tr>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Rol</th>
                <th>Telefono</th>
                <th>Contraseña</th>
                <th>Mercado</th>
                <th>Acciones</th>
            </tr>
            <tr>
                <td><input type="text" name="DNI" class="form-control" placeholder="Introduce el DNI del nuevo usuario" pattern="[0-9]{8}[A-Za-z]{1}" title="DNI debe tener al menos 8 numeros y una letra." required></td>
                <td><input type="text" name="nombre" class="form-control" placeholder="Introduce el nombre del nuevo usuario" pattern="^[A-Z][a-z]+(?: [A-Z][a-z]+)*$" required></td>
                <td>
                    <select name="Id_rol" class="form-control" required>
                        <option value="" disabled selected>Selecciona un rol</option>
                        @foreach($roles as $rol)
                            <option value="{{ $rol->Id_rol }}">{{ $rol->rol }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="tel" name="telefono" class="form-control" placeholder="Introduce el telefono del nuevo usuario" pattern="\d{9}" title="El teléfono debe tener entre 9 dígitos." required></td>
                <td><input type="password" name="contrasenya" class="form-control" required></td>
                <td>
                    <select name="Id_mercado" class="form-control" required>
                        <option value="" disabled selected>Selecciona un mercado</option>
                        @foreach($mercados as $mercado)
                            <option value="{{ $mercado->Id_mercado }}">{{ $mercado->nombre }}</option>
                        @endforeach
                    </select>
                </td>
                <td><button type="submit" class="btn btn-primary">Añadir Usuario</button></td>
            </tr>
        </table>
    </form>


@endsection
