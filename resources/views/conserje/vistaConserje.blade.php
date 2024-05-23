@extends('plantillaConserje')
@section('titulo', 'Vista Conserje')
@section('contenido')

    @php
        $currentFranja = null;
    @endphp

    <div class="container">
        <p class="mb-4 mt-2 fs-2 fw-bold">Lista de pedidos</p>
        <form action="{{ route('conserje.filtrarPorFecha') }}" method="GET" id="formFecha"
            class="form-inline mb-4 justify-content-center d-flex">
            <div class="form-group" id="buscarFecha">
                <input type="date" name="fecha" class="form-control"
                    value="{{ isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d') }}">
            </div>
            <button type="submit" id="fechaSubmit" class="btn ms-2"
                style="background-color: #009483; color:#ffffff">Filtrar</button>
        </form>

        @if (!empty($pedidosfecha) && count($pedidosfecha) > 0)
            <div id="pedidos-container" data-url="{{ route('conserje.show', ':id') }}">
                @foreach ($pedidosfecha->groupBy('franja_horaria') as $franjaHoraria => $pedidos)
                    <div id="tablasPedidos-{{ $franjaHoraria }}">
                        <h3>Franja Horaria: {{ $franjaHoraria }}</h3>
                        <table class="table table-striped" id="{{ $franjaHoraria }}">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="fs-5">
                                        <a href="{{ route('conserje.ordenarPorPuesto', ['fecha' => request('fecha'), 'orden' => request('orden') == 'asc' ? 'desc' : 'asc', 'franja_horaria' => $franjaHoraria]) }}"
                                            class="text-decoration-none text-primary font-weight-bold mx-2"
                                            title="Ordenar por puesto">Puesto</a>
                                    </th>
                                    <th class="fs-5">
                                        <a href="{{ route('conserje.ordenarPorCliente', ['fecha' => request('fecha'), 'orden' => request('orden') == 'asc' ? 'desc' : 'asc', 'franja_horaria' => $franjaHoraria]) }}"
                                            class="text-decoration-none text-primary font-weight-bold mx-2"
                                            title="Ordenar por cliente">Cliente</a>
                                    </th>
                                    <th class="fs-5">Pagado</th>
                                    <th class="fs-5">Total</th>
                                    <th class="fs-5">Dirección</th>
                                    <th class="fs-5">Nº Bultos</th>
                                    <th class="fs-5">Franja Horaria</th>
                                    <th class="fs-5">Estado</th>
                                    <th class="fs-5">Mas infomación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pedidos as $pedido)
                                    <tr>
                                        <td class="fs-5">{{ $pedido->usuario->puesto->nombre }}</td>
                                        <td class="fs-5">{{ $pedido->cliente->nombre }}</td>
                                        <td style="display: none" id="direccionMercado" class="fs-5">
                                            {{ $pedido->cliente->mercados->direccion }}
                                        </td>
                                        <td class="fs-5">
                                            @if ($pedido['pagado'] == 1)
                                                <i class="fas fa-check-circle text-success"></i> Pagado
                                            @else
                                                <i class="fas fa-times-circle text-danger"></i> No pagado
                                            @endif
                                        </td>
                                        <td class="fs-5">{{ $pedido['total_pedido'] }} €</td>
                                        <td class="direccion fs-5">{{ $pedido['direccion'] }}</td>
                                        <td class="localidad fs-5" style="display: none">
                                            {{ $pedido->direccion_pedido->localidad->localidad }}</td>
                                        <td class="fs-5">{{ $pedido['bultos'] }}</td>
                                        <td class="franja fs-5">{{ $pedido['franja_horaria'] }}</td>
                                        <td>
                                            <form action="{{ route('conserje.actualizarEstado', $pedido->Id_pedido) }}"
                                                id="form-{{ $pedido->Id_pedido }}" method="POST" class="formularioEstado">
                                                @csrf
                                                @method('POST')
                                                <select name="estado" class="selectEstado form-control">
                                                    <option value="1"
                                                        {{ $pedido->estado_pedido->estados == 'Nuevo' ? 'selected' : '' }}>
                                                        Nuevo
                                                    </option>
                                                    <option value="2"
                                                        {{ $pedido->estado_pedido->estados == 'En_preparacion' ? 'selected' : '' }}>
                                                        En
                                                        preparación
                                                    </option>
                                                    <option value="3"
                                                        {{ $pedido->estado_pedido->estados == 'Entregado' ? 'selected' : '' }}>
                                                        Entregado</option>
                                                    <option value="4"
                                                        {{ $pedido->estado_pedido->estados == 'Cancelado' ? 'selected' : '' }}>
                                                        Cancelado</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td><a class="btn ver-mas fs-5" href="#"
                                                style="background-color: #009483; color:#ffffff"
                                                data-pedido="{{ $pedido->Id_pedido }}">VER MÁS</a>
                                        </td>
                                    </tr>
                                @endforeach
                    </div>

                    </tbody>
                    </table>
                    <a href="#" class="btn btn-secondary generarRuta fs-5" data-franja="{{ $franjaHoraria }}">Generar
                        Ruta
                        para
                        {{ $franjaHoraria }}</a>
                    <hr>
            </div>
        @endforeach
    @else
        <p class="fs-5">No se encontraron pedidos</p>
        @endif




        <div id="datosCliente" style="display: none;" class="container mb-2">
            <h2>Datos Cliente</h2>
            <ul class="listaDatosCliente list-group list-group-flush mb-3" style="list-style-type:none;">
                <li class="list-group-item mb-2 fs-5"><strong>Nombre: </strong><span id="nombreCliente"></span></li>
                <li class="list-group-item mb-2 fs-5"><strong>DNI: </strong><span id="dniCliente"></span></li>
                <li class="list-group-item mb-2 fs-5"><strong>Dirección: </strong><span id="direccionCliente"></span></li>
                <li class="list-group-item mb-2 fs-5"><strong>Teléfono: </strong><span id="telefonoCliente"></span></li>
            </ul>
        </div>
        <div id="detallesPedido" style="display: none;" class="container">
            <h2>Detalles del Pedido</h2>
            <table class="table">
                <tr>
                    <th class="fs-5">Usuario</th>
                    <th class="fs-5">Total</th>
                    <th class="fs-5">Pagado</th>
                    <th id="metodoTh" style="display: none;" class="fs-5">Efectivo/Tarjeta</th>
                    <th class="fs-5">Bultos</th>
                    <th id="bultos_perecederosTh" class="fs-5">Bultos Perecederos</th>
                    <th class="fs-5">Fecha Pedido</th>
                    <th class="fs-5">Franja Horaria</th>
                    <th class="fs-5">Estado</th>
                </tr>
                <tr>
                    <td id="usuario" class="fs-5"></td>
                    <td id="total" class="fs-5"></td>
                    <td id="pagado" class="fs-5"></td>
                    <td id="metodo" style="display: none;" class="fs-5"></td>
                    <td id="bultos" class="fs-5"></td>
                    <td id="bultos_perecederos" class="fs-5"></td>
                    <td id="fecha_pedido" class="fs-5"></td>
                    <td id="franja_horaria" class="fs-5"></td>
                    <td id="estado" class="fs-5"></td>
                </tr>
            </table>
        </div>
    </div>

    </div>

    <script src="{{ asset('js/ordenarPorPuesto.js') }}"></script>
    <script src="{{ asset('js/generarRuta.js') }}"></script>
    <script src="{{ asset('js/cambiarEstadoPedido.js') }}"></script>
    <script src="{{ asset('js/cargarDetalles.js') }}"></script>


@endsection
