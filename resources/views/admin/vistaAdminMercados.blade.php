@extends('plantillaAdmin')
@section('titulo', 'Baja Mercados')
@section('contenido')

    {{-- Vista para hacer un crud de mercados --}}
    <p class="mb-4 fs-2 fw-bold text-center">Listado de mercados</p>
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
        <table class="table table-striped" id="mercados">
            <thead class="thead-dark">
                <tr>
                    <th class="fs-3">Nombre</th>
                    <th class="fs-3">Localidad</th>
                    <th class="fs-3">Direccion</th>
                    <th class="fs-3">Dar de baja / alta</th>
                </tr>
            </thead>
            <tbody>
                {{-- bucle para recorrer los mercados pasados  --}}
                @forelse ($mercados as $mercado)
                    {{-- if para que salgan todos los usuarios menos los del rol administrador --}}
                    <tr>
                        <td class="fs-5">{{ $mercado->nombre }}</td>
                        <td class="fs-5">{{ $mercado->localidad->localidad }}</td>
                        <td class="fs-5">{{ $mercado->direccion }}</td>
                        <td class="fs-5"><a class="btn fs-5 {{ $mercado->baja == 0 ? 'btn-danger' : 'btn-success' }}"
                                href="{{ route('baja.mercados', $mercado->Id_mercado) }}">{{ $mercado->baja == 0 ? 'DAR DE BAJA' : 'DAR DE ALTA' }}</a>
                        </td>
                    </tr>
                @empty
                    <p>No se encontraron mercados</p>
                @endforelse
            </tbody>

        </table>

        <p class="mb-4 fs-2 fw-bold text-center">Añadir mercados</p>
        <form class="formularioMercados" action="{{ route('anyadir.mercados') }}" method="post">
            @csrf
            <table class="table table-striped" id="anyadirMercados">
                <thead class="thead-dark">
                    <tr>
                        <th class="fs-3">Nombre</th>
                        <th class="fs-3">Localidad</th>
                        <th class="fs-3">Direccion</th>
                        <th class="fs-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="nombre" class="form-control"
                                placeholder="Introduce el nombre del nuevo mercado"
                                title="Introduce el nuevo nombre del mercado" pattern="^[A-Za-z0-9' .-]+$" required>
                        </td>
                        <td>
                            <select name="localidad" id="localidadSelect" class="form-control" required
                                title="Selecciona la localidad del mercado">
                                <option value="" disabled selected>Selecciona una localidad</option>
                                @foreach ($localidades as $localidad)
                                    <option value="{{ $localidad->Id_localidad }}">{{ $localidad->localidad }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="text" name="direccion" class="form-control"
                                title="Añade la direccion de ese mercado"
                                placeholder="Introduce la direccion del nuevo mercado" pattern="^[A-Za-z0-9' .-]+$"
                                required></td>
                        <td><button type="submit" class="btn btn-primary fs-5 ">Añadir Mercado</button></td>
                    </tr>
                </tbody>

            </table>
        </form>
    </div>


    <script>
        $(document).ready(function() {
            $('#localidadSelect').select2({
                placeholder: 'Selecciona una localidad',
                allowClear: true
            });
        });
    </script>
@endsection
