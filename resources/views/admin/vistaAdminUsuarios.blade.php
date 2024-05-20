@extends('plantillaAdmin')
@section('titulo', 'Inicio')
@section('contenido')

<h1>Listado de clientes</h1>
<table class="table table-striped" id="clientes">
    <tr>
        <th>DNI</th>
        <th>Nombre</th>
        <th>Rol</th>
        <th>Telefono</th>
        <th>Contrasña</th>
        <th>Mercado</th>
        <th>Dar de baja / alta</th>
    </tr>
    @forelse ($usuarios as $usuario)
    <tr>
        <td>{{ $usuario->DNI }}</td>
        <td>{{ $usuario->nombre }}</td>
        <td>{{ $usuario->rol->rol }}</td>
        <td>{{ $usuario->telefono }}</td>
        <td>{{ $usuario->mercado->nombre }}</td>
        <td>{{ $usuario->contrasenya }}</td>
        <td><a class="btn {{ $usuario->baja == 0 ? 'btn-danger' : 'btn-success' }}" href="#">{{ $usuario->baja == 0 ? 'DAR DE BAJA' : 'DAR DE ALTA' }}</a></td>
    </tr>
    @empty
    <p>No se encontraron pedidos</p>
@endforelse
</table>
@endsection