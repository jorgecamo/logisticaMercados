@extends('plantillaAdmin')
@section('titulo', 'Baja Usuarios')
@section('contenido')

    {{-- Vista para hacer un crud de usuarios --}}
    <p class="mb-4 fs-2 fw-bold text-center">Listado de usuarios</p>
    <div class="container">
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
        <table class="table table-striped" id="usuarios">
            <thead class="thead-dark">
                <tr>
                    <th class="fs-3">DNI</th>
                    <th class="fs-3">Nombre</th>
                    <th class="fs-3">Rol</th>
                    <th class="fs-3">Telefono</th>
                    <th class="fs-3">Mercado</th>
                    <th class="fs-3">Dar de baja / alta</th>
                </tr>
            </thead>
            <tbody>
                {{-- bucle para recorrer los usuarios pasados  --}}
                @forelse ($usuarios as $usuario)
                    {{-- if para que salgan todos los usuarios menos los del rol administrador --}}
                    @if ($usuario->rol->Id_rol != 2)
                        <tr>
                            <td class="fs-5">{{ $usuario->DNI }}</td>
                            <td class="fs-5">{{ $usuario->nombre }}</td>
                            <td class="fs-5">{{ $usuario->rol->rol }}</td>
                            <td class="fs-5">{{ $usuario->telefono }}</td>
                            <td class="fs-5">{{ $usuario->mercado->nombre }}</td>
                            <td class="fs-5"><a class="btn fs-5 {{ $usuario->baja == 0 ? 'btn-danger' : 'btn-success' }}"
                                    href="{{ route('baja.usuarios', $usuario->Id_usuario) }}">{{ $usuario->baja == 0 ? 'DAR DE BAJA' : 'DAR DE ALTA' }}</a>
                            </td>
                        </tr>
                    @endif
                @empty
                    <p>No se encontraron usuarios</p>
                @endforelse
            </tbody>

        </table>

        <p class="mb-4 fs-2 fw-bold text-center">Añadir usuarios</p>
        <form class="formularioUsuarios" action="{{ route('anyadir.usuarios') }}" method="post">
            @csrf
            <table class="table table-striped" id="anyadirUsuarios">
                <thead class="thead-dark">
                    <tr>
                        <th class="fs-3">DNI</th>
                        <th class="fs-3">Nombre</th>
                        <th class="fs-3">Rol</th>
                        <th class="fs-3">Telefono</th>
                        <th class="fs-3">Contraseña</th>
                        <th class="fs-3">Mercado</th>
                        <th class="fs-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="DNI" class="form-control"
                                placeholder="Introduce el DNI del nuevo usuario" pattern="[0-9]{8}[A-Za-z]{1}"
                                title="DNI debe tener al menos 8 numeros y una letra." required></td>
                        <td><input type="text" name="nombre" class="form-control"
                                placeholder="Introduce el nombre del nuevo usuario" pattern="^[A-Z][a-z]+(?: [A-Z][a-z]+)*$"
                                required></td>
                        <td>
                            <select name="Id_rol" class="form-control" required title="Seleciona el rol del usuario.">
                                <option value="" disabled selected>Selecciona un rol</option>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->Id_rol }}">{{ $rol->rol }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="tel" name="telefono" class="form-control"
                                placeholder="Introduce el telefono del nuevo usuario" pattern="\d{9}"
                                title="El teléfono debe tener entre 9 dígitos." required></td>
                        <td><input type="password" name="contrasenya" class="form-control" required></td>
                        <td>
                            <select name="Id_mercado" class="form-control" required
                                title="Seleciona el mercado del usuario.">
                                <option value="" disabled selected>Selecciona un mercado</option>
                                @foreach ($mercados as $mercado)
                                    <option value="{{ $mercado->Id_mercado }}">{{ $mercado->nombre }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><button type="submit" class="btn fs-5 btn-primary">Añadir Usuario</button></td>
                    </tr>
                </tbody>

            </table>
        </form>
    </div>



@endsection
