@extends('plantillaAdmin')
@section('titulo', 'Baja Clientes')
@section('contenido')

    <p class="mb-4 fs-2 fw-bold text-center">Listado de clientes</p>
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
        <table class="table table-striped" id="clientes">
            <thead class="thead-dark">
                <tr>
                    <th class="fs-3">DNI</th>
                    <th class="fs-3">Nombre</th>
                    <th class="fs-3">Telefono</th>
                    <th class="fs-3">Correo</th>
                    <th class="fs-3">Puntos</th>
                    <th class="fs-3">Mercado</th>
                    <th class="fs-3">Dar de baja / alta</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($clientes as $cliente)
                    <tr>
                        <td class="fs-5">{{ $cliente->DNI }}</td>
                        <td class="fs-5">{{ $cliente->nombre }}</td>
                        <td class="fs-5">{{ $cliente->telefono }}</td>
                        <td class="fs-5">{{ $cliente->correo }}</td>
                        <td class="fs-5">{{ $cliente->puntos }}</td>
                        <td class="fs-5">{{ $cliente->mercados->nombre }}</td>
                        <td><a class="btn fs-5 {{ $cliente->baja == 0 ? 'btn-danger' : 'btn-success' }}"
                                href="{{ route('admin.edit', $cliente->Id_cliente) }}">{{ $cliente->baja == 0 ? 'DAR DE BAJA' : 'DAR DE ALTA' }}</a>
                        </td>
                    </tr>
                @empty
                    <p>No se encontraron clientes</p>
                @endforelse
            </tbody>

        </table>
    </div>

@endsection
