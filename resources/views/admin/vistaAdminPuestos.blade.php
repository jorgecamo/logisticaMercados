@extends('plantillaAdmin')
@section('titulo', 'Baja Puestos')
@section('contenido')



    {{-- Vista para hacer un crud de puestos --}}
    <p class="mb-4 fs-2 fw-bold text-center">Listado de puestos</p>
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
        <table class="table table-striped" id="puestos">
            <thead class="thead-dark">
                <tr>
                    <th class="fs-3">Mercado</th>
                    <th class="fs-3">Nombre</th>
                    <th class="fs-3">Usuario</th>
                    <th class="fs-3">Dar de baja / alta</th>
                </tr>
            </thead>
            <tbody>
                {{-- bucle para recorrer los puestos pasados  --}}
                @forelse ($puestos as $puesto)
                    <tr>
                        <td class="fs-5">{{ $puesto->mercado->nombre }}</td>
                        <td class="fs-5">{{ $puesto->nombre }}</td>
                        <td class="fs-5">{{ $puesto->usuario->nombre }}</td>
                        <td><a class="btn fs-5 {{ $puesto->baja == 0 ? 'btn-danger' : 'btn-success' }}"
                                href="{{ route('baja.puestos', $puesto->Id_puesto) }}">{{ $puesto->baja == 0 ? 'DAR DE BAJA' : 'DAR DE ALTA' }}</a>
                        </td>
                    </tr>
                @empty
                    <p>No se encontraron puestos</p>
                @endforelse
            </tbody>

        </table>

        <p class="mb-4 fs-2 fw-bold text-center">Añadir Puestos</p>
        <form class="formularioPuestos" action="{{ route('anyadir.puestos') }}" method="post">
            @csrf
            <table class="table table-striped" id="anyadirUsuarios">
                <thead class="thead-dark">
                    <tr>
                        <th class="fs-3">Mercado</th>
                        <th class="fs-3">Nombre</th>
                        <th class="fs-3">Usuario</th>
                        <th class="fs-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="Id_mercado" class="form-control" required
                                title="Selecciona el mercado al que pertenece ese puesto">
                                <option value="" disabled selected>Selecciona un mercado</option>
                                @foreach ($mercados as $mercado)
                                    <option value="{{ $mercado->Id_mercado }}">{{ $mercado->nombre }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="text" name="nombre" class="form-control" title="Añade el nombre del puesto"
                                placeholder="Introduce el nombre del nuevo puesto" pattern="^[A-Za-z0-9' .-]+$" required>
                        </td>
                        <td>
                            <select name="Id_usuario" class="form-control" required
                                title="Selecciona el usuario propietario del puesto">
                                <option value="" disabled selected>Selecciona un usuario dueño del puesto</option>
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ $usuario->Id_usuario }}">{{ $usuario->nombre }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><button type="submit" class="btn fs-5" style="background-color: #009483; color:#ffffff">Añadir Puesto</button></td>
                    </tr>
                </tbody>

            </table>
        </form>
    </div>



@endsection
