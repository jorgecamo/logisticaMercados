@extends('plantillaConserje')
@section('titulo', 'Vista Conserje Añadir Direcciones')
@section('contenido')
    {{-- Mostrar mensajes de éxito o error --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <p class="mb-4 fs-2 fw-bold text-center">Añadir direcciones</p>
    <div class="container">
        <form class="formularioClientes" action="{{ route('conserje.anyadirDirecciones') }}" method="post">
            @csrf
            <table class="table table-striped" id="anyadirClientes">
                <thead class="thead-dark">
                    <tr>
                        <th class="fs-3">Dirección</th>
                        <th class="fs-3">Cliente</th>
                        <th class="fs-3">Localidad</th>
                        <th class="fs-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fs-3"><input type="text" name="direcciones" class="form-control"
                                placeholder="Introduce la direccion que quieres añadir" pattern="^[A-Za-z0-9' .-]+$"
                                title="Escribe la direccion nueva" required>
                        </td>
                        <td class="fs-3">
                            <select class="form-control" name="id_cliente" id="id_cliente" required title="Selecciona un cliente para asociar esa direccion">
                                <option value="">--Porfavor selecciona una opcion--</option>
                                @foreach ($clientes as $cliente)
                                    < <option value="{{ $cliente->Id_cliente }}"
                                        @if ($cliente->Id_cliente == $Id_cliente) selected @endif>{{ $cliente->nombre }}</option>
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
                        <td><button type="submit" class="btn fs-5" style="background-color: #009483; color:#ffffff">Añadir Direccion</button></td>
                    </tr>
                </tbody>

            </table>
        </form>
    </div>

    <script src="{{asset('js/selectBuscador.js')}}"></script>
@endsection
