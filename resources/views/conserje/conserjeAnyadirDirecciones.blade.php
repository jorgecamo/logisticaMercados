@extends('plantillaConserje')
@section('titulo', 'Vista Conserje Añadir Direcciones')
@section('contenido')
    {{-- Mostrar mensajes de éxito o error --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1>Añadir clientes</h1>
    <form class="formularioClientes" action="{{ route('conserje.anyadirDirecciones') }}" method="post">
        @csrf
        <table class="table table-striped" id="anyadirClientes">
            <tr>
                <th>Direccion</th>
                <th>Cliente</th>
                <th>Localidad</th>
                <th>Acciones</th>
            </tr>
            <tr>
                <td><input type="text" name="direcciones" class="form-control"
                        placeholder="Introduce la direccion que quieres añadir" pattern="^[A-Za-z0-9' .-]+$" required>
                </td>
                <td>
                    <select class="form-control" name="id_cliente" id="id_cliente" required>
                        <option value="">--Porfavor selecciona una opcion--</option>
                        @foreach ($clientes as $cliente)
                            < <option value="{{ $cliente->Id_cliente }}" @if($cliente->Id_cliente == $Id_cliente) selected @endif>{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="localidad" id="localidadSelect" class="form-control" required>
                        <option value="" disabled selected>Selecciona una localidad</option>
                        @foreach ($localidades as $localidad)
                            <option value="{{ $localidad->Id_localidad }}">{{ $localidad->localidad }}</option>
                        @endforeach
                    </select>
                </td>
                <td><button type="submit" class="btn btn-primary">Añadir Direccion</button></td>
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
