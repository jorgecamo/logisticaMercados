@extends('plantillaConserje')
@section('titulo', 'Vista Conserje')
@section('contenido')


    <h1>Lista de pedidos</h1>
    <form action="{{ route('conserje.filtrarPorFecha') }}" method="GET" id="formFecha">
        <input type="date" name="fecha" value="{{ isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d') }}">
        <button type="submit" id="fechaSubmit">Filtrar</button>
    </form>
    @if (!empty($pedidosfecha))
        <table class="table table-striped" id="pedidosTabla">
            <tr>
                <th><a href="{{ route('conserje.ordenarPorPuesto', ['fecha' => request('fecha'), 'orden' => request('orden') == 'asc' ? 'desc' : 'asc']) }}"
                        id="ordenarPorPuesto" class="text-decoration-none text-primary font-weight-bold mx-2" title="Ordenar por puesto">Puesto</a></th>
                <th><a href="{{ route('conserje.ordenarPorCliente', ['fecha' => request('fecha'), 'orden' => request('orden') == 'asc' ? 'desc' : 'asc']) }}"
                    id="ordenarPorCliente" class="text-decoration-none text-primary font-weight-bold mx-2" title="Ordenar por cliente">Cliente</th>
                <th>Pagado</th>
                <th>Total</th>
                <th>Direccion</th>
                <th>Nº Bultos</th>
                <th>Franja Horaria</th>
                <th>Estado</th>
                <th>Mas infomación</th>
            </tr>
            @forelse ($pedidosfecha as $pedido)
                <tr>
                    <td>{{ $pedido->usuario->puesto->nombre }}</td>
                    <td>{{ $pedido->cliente->nombre }}</td>
                    <td>
                        @if ($pedido['pagado'] == 1)
                            <i class="fas fa-check-circle text-success"></i> Pagado
                        @else
                            <i class="fas fa-times-circle text-danger"></i> No pagado
                        @endif
                    </td>
                    <td>{{ $pedido['total_pedido'] }} €</td>
                    <td>{{ $pedido['direccion'] }}</td>
                    <td>{{ $pedido['bultos'] }}</td>
                    <td>{{ $pedido['franja_horaria'] }}</td>
                    <td>
                        <form action="{{ route('conserje.actualizarEstado', $pedido->Id_pedido) }}"
                            id="form-{{ $pedido->Id_pedido }}" method="POST" class="formularioEstado">
                            @csrf
                            @method('POST')
                            <select name="estado" class="selectEstado">
                                <option value="1" {{ $pedido->estado_pedido->estados == 'Nuevo' ? 'selected' : '' }}>
                                    Nuevo</option>
                                <option value="2"
                                    {{ $pedido->estado_pedido->estados == 'En_preparacion' ? 'selected' : '' }}>
                                    En preparación</option>
                                <option value="3"
                                    {{ $pedido->estado_pedido->estados == 'Entregado' ? 'selected' : '' }}>Entregado
                                </option>
                                <option value="4"
                                    {{ $pedido->estado_pedido->estados == 'Cancelado' ? 'selected' : '' }}>Cancelado
                                </option>
                            </select>
                        </form>
                    </td>
                    <td><a class="btn btn-primary ver-mas" href="#" data-pedido="{{ $pedido->Id_pedido }}">VER
                            MAS</a></td>
                </tr>
            @empty
                <p>No se encontraron pedidos</p>
            @endforelse

        </table>
    @endif
    <div id="datosCliente" style="display: none;">
        <h2>Datos Cliente</h2>
        <ul class="listaDatosCliente list-group list-group-flush mb-3" style="list-style-type:none;">
            <li class="list-group-item"><strong>Nombre: </strong><span id="nombreCliente"></span></li>
            <li class="list-group-item"><strong>DNI: </strong><span id="dniCliente"></span></li>
            <li class="list-group-item"><strong>Dirección: </strong><span id="direccionCliente"></span></li>
            <li class="list-group-item"><strong>Teléfono: </strong><span id="telefonoCliente"></span></li>
        </ul>
    </div>
    <div id="detallesPedido" style="display: none;">
        <h2>Detalles del Pedido</h2>
        <table class="table">
            <tr>
                <th>Usuario</th>
                <th>Total</th>
                <th>Pagado</th>
                <th id="metodoTh" style="display: none;">Efectivo/Tarjeta</th>
                <th>Bultos</th>
                <th id="bultos_perecederosTh">Bultos Perecederos</th>
                <th>Fecha Pedido</th>
                <th>Franja Horaria</th>
                <th>Estado</th>
            </tr>
            <tr>
                <td id="usuario"></td>
                <td id="total"></td>
                <td id="pagado"></td>
                <td id="metodo" style="display: none;"></td>
                <td id="bultos"></td>
                <td id="bultos_perecederos"></td>
                <td id="fecha_pedido"></td>
                <td id="franja_horaria"></td>
                <td id="estado"></td>
            </tr>
        </table>
    </div>

    <script>
        var verMas = false; // Variable para actualizar la vista del pedido si se ha clickado ver mas en algun momento

        //funcion para cambiar la primera letra a mayusculas 
        function toTitleCase(str) {
            return str.toLowerCase().split(' ').map(function(word) {
                return (word.charAt(0).toUpperCase() + word.slice(1));
            }).join(' ');
        }

        // Funcion para formatear la fecha
        function formatearFecha(fechaCompleta) {
            var fecha = new Date(fechaCompleta);

            // Obtener el día, el mes y el año
            var dia = fecha.getDate();
            var mes = fecha.getMonth() + 1;
            var año = fecha.getFullYear();

            // Asegurarse de que el día y el mes tengan dos dígitos
            if (dia < 10) {
                dia = '0' + dia;
            }
            if (mes < 10) {
                mes = '0' + mes;
            }

            // Formatear la fecha en d-m-Y
            var fechaFormateada = dia + '-' + mes + '-' + año;

            return fechaFormateada;
        }

        //formulario fecha
        var formularioFecha = document.getElementById('formFecha');

        // Variable para controlar si el formulario ya se ha enviado, para que no se envie infinitamente
        var formularioEnviado = localStorage.getItem('formularioEnviado');

        // Función para enviar el formulario solo una vez al cargar la pagina, con ayuda de localstorage
        function enviarFormulario() {
            if (!formularioEnviado) {
                formularioFecha.submit();
                localStorage.setItem('formularioEnviado', true);
            }
        }
        //Funcion para que se ejecute el formulario fecha con el boton submit
        formularioFecha.addEventListener('submit', function(event) {
            event.preventDefault();
            this.submit();
        });

        window.addEventListener('DOMContentLoaded', function() {
            if (!formularioEnviado) {
                enviarFormulario();
            }
        });

        // funcion ver mas del pedido y aparece los datos del pedido y del cliente 

        document.querySelectorAll('.ver-mas').forEach(function(element) {
            element.addEventListener('click', function(event) {
                event.preventDefault();
                var pedidoId = this.getAttribute('data-pedido');
                var pedidoDetalles = document.getElementById('detallesPedido');
                var datosCliente = document.getElementById('datosCliente');


                fetch('{{ route('conserje.show', ':id') }}'.replace(':id', pedidoId))
                    .then(response => response.json())
                    .then(data => {
                        verMas = true;
                        // Datos de la lista detalle cliente
                        document.getElementById('nombreCliente').innerText = data.datosCliente.nombre;
                        document.getElementById('dniCliente').innerText = data.datosCliente.DNI;
                        document.getElementById('direccionCliente').innerText = data.pedidoPorId
                            .direccion;
                        document.getElementById('telefonoCliente').innerText = data.datosCliente
                            .telefono;

                        // Datos de la tabla detalles pedido
                        document.getElementById('usuario').innerText = data.usuarioQueRealizaElPedido
                            .nombre;
                        document.getElementById('total').innerText = data.pedidoPorId.total_pedido +
                            " €";
                        document.getElementById('pagado').innerText = data.pedidoPorId.pagado ? "Sí" :
                            "No";
                        document.getElementById('bultos').innerText = data.pedidoPorId.bultos;
                        document.getElementById('fecha_pedido').innerText = formatearFecha(data
                            .pedidoPorId.fecha_pedido);
                        document.getElementById('franja_horaria').innerText = data.pedidoPorId
                            .franja_horaria;


                        if (!data.pedidoPorId.bultos_perecederos) {
                            document.getElementById('bultos_perecederosTh').style.display = 'none';
                            document.getElementById('bultos_perecederos').style.display = 'none';

                        } else {
                            document.getElementById('bultos_perecederosTh').style.display =
                                'table-cell';
                            document.getElementById('bultos_perecederos').innerText = data.pedidoPorId
                                .bultos_perecederos;
                            document.getElementById('bultos_perecederos').style.display = 'table-cell';

                        }

                        document.getElementById('estado').innerText = data.estadoPedido.estados.replace(
                            /_/g, ' ');

                        var estadoTd = document.getElementById('estado');
                        estadoTd.className = ''; // Limpiar cualquier clase existente
                        estadoTd.classList.add('estado-' + data.estadoPedido.estados.toLowerCase()
                            .replace(/_/g, ''));

                        // Mostrar el método de pago si el pedido no está pagado
                        if (!data.pedidoPorId.pagado) {
                            document.getElementById('metodoTh').style.display = 'table-cell';
                            document.getElementById('metodo').innerText = toTitleCase(data
                                .metodoPagoPedido.metodo_pago);
                            document.getElementById('metodo').style.display = 'table-cell';
                        } else {
                            document.getElementById('metodoTh').style.display = 'none';
                            document.getElementById('metodo').style.display = 'none';
                        }

                        pedidoDetalles.style.display = 'block';
                        datosCliente.style.display = 'block';

                    })
                    .catch(error => {
                        console.error('Error al cargar los detalles del pedido:', error);
                    });
            });
        });

        //Funcion para cambiar el estado del pedido, uso el change para que no me haga falta pulsar ningun boton

        document.querySelectorAll('.formularioEstado').forEach(function(form) {
            form.addEventListener('change', function(event) {
                event.preventDefault();
                var botonVerMas = this.closest('tr').querySelector('.ver-mas');
                var formData = new FormData(this);
                fetch(this.action, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log(data.message);
                            if (verMas) {
                                botonVerMas.click();
                            }
                        } else {
                            console.error('Error al actualizar el estado del pedido');
                        }
                    })
                    .catch(error => {
                        console.error('Error al actualizar el estado del pedido:', error);
                    });
            });
        });

        function ordenarPorPuesto() {
            // Obtener la dirección actual de orden
            var ordenActual = "{{ request('orden') == 'asc' ? 'desc' : 'asc' }}";

            // Obtener la fecha actual del formulario
            var fechaActual = document.querySelector("input[name='fecha']").value;

            // Construir la URL con los parámetros de orden y fecha
            var url = "{{ route('conserje.ordenarPorPuesto', ['fecha' => ':fecha', 'orden' => ':orden']) }}";
            url = url.replace(':fecha', fechaActual).replace(':orden', ordenActual);

            // Hacer la solicitud AJAX
            fetch(url)
                .then(response => response.text())
                .then(data => {
                    // Reemplazar el contenido de la tabla con los datos actualizados
                    document.getElementById('pedidosTabla').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error al ordenar por puesto:', error);
                });
        }
    </script>
@endsection
