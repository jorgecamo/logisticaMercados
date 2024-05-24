@extends('plantillaCliente')
@section('titulo', 'Inicio')
@section('contenido')

<div class="container">
    <p class="fs-2">Bienvenido {{ $cliente->nombre }}</p>
    <p class="fs-3">Puntos: {{ $cliente->puntos }}</p>
    <table class="table table-striped" id="tablaPedidosClientes">
        <thead class="thead-dark">
            <tr>
                <th class="fs-5">Mercado</th>
                <th class="fs-5">Puesto</th>
                <th class="fs-5">Fecha</th>
                <th class="fs-5">Total</th>
                <th class="fs-5">Dirección</th>
                <th class="fs-5">Nº Bultos</th>
                <th class="fs-5">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedidos as $pedido)
                <tr>
                    <td class="fs-5">{{ $pedido->usuario->mercado->nombre }}</td>
                    <td class="fs-5">{{ $pedido->usuario->puesto->nombre }}</td>
                    <td class="fs-5">{{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y') }} </td>
                    <td class="fs-5">{{ $pedido['total_pedido'] }} €</td>
                    <td class="direccion fs-5">{{ $pedido['direccion'] }}</td>
                    <td class="fs-5">{{ $pedido['bultos'] }}</td>
                    <td class="fs-5">
                        {{ $pedido->estado_pedido->estados }}
                    </td>
                </tr>
            @endforeach
</div>

</tbody>
</table>
</div>


@endsection
