@extends('plantillaAdmin')
@section('titulo', 'Inicio')
@section('contenido')
    {{-- Vista para hacer un crud de mercados --}}
    <h1>Listado de mercados</h1>
    <table class="table table-striped" id="mercados">
        <tr>
            <th>Nombre</th>
            <th>Localidad</th>
            <th>Direccion</th>
            <th>Dar de baja / alta</th>
        </tr>
        {{-- bucle para recorrer los mercados pasados  --}}
        @forelse ($mercados as $mercado)
            {{-- if para que salgan todos los usuarios menos los del rol administrador --}}
                <tr>
                    <td>{{ $mercado->nombre }}</td>
                    <td>{{ $mercado->localidad->localidad }}</td>
                    <td>{{ $mercado->direccion }}</td>
                    <td><a class="btn {{ $mercado->baja == 0 ? 'btn-danger' : 'btn-success' }}"
                            href="{{ route('baja.mercados', $mercado->Id_mercado) }}">{{ $mercado->baja == 0 ? 'DAR DE BAJA' : 'DAR DE ALTA' }}</a>
                    </td>
                </tr>
        @empty
            <p>No se encontraron mercados</p>
        @endforelse
    </table>

    <h1>Añadir mercados</h1>
    <form class="formularioPedido" action="{{ route('anyadir.mercados') }}" method="post">
        @csrf
        <table class="table table-striped" id="anyadirMercados">
            <tr>
                <th>Nombre</th>
                <th>Localidad</th>
                <th>Direccion</th>
                <th>Acciones</th>
            </tr>
            <tr>
                <td><input type="text" name="nombre" class="form-control" placeholder="Introduce el nombre del nuevo usuario" pattern="^[A-Za-z0-9' .-]+$" required></td>
                <td>
                    <select name="localidad" id="localidadSelect" class="form-control" required>
                        <option value="" disabled selected>Selecciona una localidad</option>
                        @foreach($localidades as $localidad)
                            <option value="{{ $localidad->Id_localidad }}">{{ $localidad->localidad }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" name="direccion" class="form-control" placeholder="Introduce la direccion del nuevo mercado" pattern="^[A-Za-z0-9' .-]+$" required></td>
                <td><button type="submit" class="btn btn-primary">Añadir Usuario</button></td>
            </tr>
        </table>
    </form>

    <script>
        $(document).ready(function() {
            $('#localidadSelect').select2({
                placeholder: 'Selecciona una localidad',
                allowClear: true
            });
        });
    </script>
@endsection
