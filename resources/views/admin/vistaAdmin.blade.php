@extends('plantillaAdmin')
@section('titulo', 'Inicio')
@section('contenido')

<h1>Listado de clientes</h1>
<table class="table table-striped" id="clientes">
    <tr>
        <th>DNI</th>
        <th>Nombre</th>
        <th>Telefono</th>
        <th>Correo</th>
        <th>Puntos</th>
        <th>Mercado</th>
        <th>Dar de baja / alta</th>
    </tr>
    @forelse ($clientes as $cliente)
    <tr>
        <td>{{ $cliente->DNI }}</td>
        <td>{{ $cliente->nombre }}</td>
        <td>{{ $cliente->telefono }}</td>
        <td>{{ $cliente->correo }}</td>
        <td>{{ $cliente->puntos }}</td>
        <td>{{ $cliente->mercados->nombre }}</td>
        <td><a class="btn {{ $cliente->baja == 0 ? 'btn-danger' : 'btn-success' }}" href="{{ route('admin.edit', $cliente->Id_cliente) }}">{{ $cliente->baja == 0 ? 'DAR DE BAJA' : 'DAR DE ALTA' }}</a></td>
    </tr>
    @empty
    <p>No se encontraron clientes</p>
@endforelse
</table>
@endsection