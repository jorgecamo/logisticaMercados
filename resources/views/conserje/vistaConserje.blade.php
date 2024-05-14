@extends('plantilla')
@section('titulo', 'Vista Conserje')
@section('contenido')


    <h1>Lista de pedidos</h1>
    <form action="{{ route('conserje.filtrarPorFecha') }}" method="GET" id="formFecha">
        <input type="date" name="fecha" value="{{ isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d') }}">
        <button type="submit" id="fechaSubmit">Filtrar</button>
    </form>
    @if (!empty($pedidosfecha))
        <table class="table table-striped">
            <tr>
                <th>Cliente</th>
                <th>Pagado</th>
                <th>Total</th>
                <th>Direccion</th>
                <th>Estado</th>
                <th>Mas infomación</th>
            </tr>
            @forelse ($pedidosfecha as $pedido)
                <tr>
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
                    <td>
                        <form action="{{ route('conserje.actualizarEstado', $pedido->Id_pedido) }}"
                            id="form-{{ $pedido->Id_pedido }}" method="POST" class="formularioEstado">
                            @csrf
                            @method('POST')
                            <select name="estado" class="selectEstado">
                                <option value="Nuevo" {{ $pedido->estado == 'Nuevo' ? 'selected' : '' }}>Nuevo</option>
                                <option value="Preparacion" {{ $pedido->estado == 'Preparacion' ? 'selected' : '' }}>
                                    En preparación</option>
                                <option value="Entregado" {{ $pedido->estado == 'Entregado' ? 'selected' : '' }}>Entregado
                                </option>
                                <option value="Cancelado" {{ $pedido->estado == 'Cancelado' ? 'selected' : '' }}>Cancelado
                                </option>
                            </select>
                        </form>
                    </td>
                    <td><a class="btn btn-primary ver-mas"href="#" data-pedido="{{ $pedido->Id_pedido }}">VER MAS</a></td>
                </tr>
            @empty
                <p>No se encontraron pedidos</p>
            @endforelse

        </table>
    @endif

    <div id="pedido-detalles" style="display: none;">
        <h2>Detalles del Pedido</h2>
        <table class="table">
            <tr>
                <th>Puesto</th>
                <th>Total</th>
                <th>Pagado</th>
                <th id="metodoTh" style="display: none;">Efectivo/Tarjeta</th>
                <th>Estado</th>
            </tr>
            <tr>
                <td id="puesto"></td>
                <td id="total"></td>
                <td id="pagado"></td>
                <td id="metodo" style="display: none;"></td>
                <td id="estado"></td>
            </tr>
        </table>
    </div>

    <script>
        //funcion para cambiar la primera letra a mayusculas 
        function toTitleCase(str) {
            return str.toLowerCase().split(' ').map(function(word) {
                return (word.charAt(0).toUpperCase() + word.slice(1));
            }).join(' ');
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
        //Funcion para que se ejecute el formulario fecha con el botoon submit
        formularioFecha.addEventListener('submit', function(event) {
            event.preventDefault();
            this.submit();
        });

        window.addEventListener('DOMContentLoaded', function() {
            if (!formularioEnviado) {
                enviarFormulario();
            } else {
                // Limpiar localStorage si el formulario ya se ha enviado antes
                localStorage.removeItem('formularioEnviado');
            }
        });

        document.querySelectorAll('.ver-mas').forEach(function(element) {
            element.addEventListener('click', function(event) {
                event.preventDefault();
                var pedidoId = this.getAttribute('data-pedido');
                var pedidoDetalles = document.getElementById('pedido-detalles');

                fetch('{{ route('conserje.show', ':id') }}'.replace(':id', pedidoId))
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('puesto').innerText = data.puestoQueRealizaElPedido
                            .nombre;
                        document.getElementById('pagado').innerText = data.pedidoPorId.pagado ? "Sí" :
                            "No";
                        document.getElementById('total').innerText = data.pedidoPorId.total_pedido +
                            " €";
                        document.getElementById('estado').innerText = data.pedidoPorId.estado;

                        var estadoTd = document.getElementById('estado');
                        estadoTd.className = ''; // Limpiar cualquier clase existente
                        estadoTd.classList.add('estado-' + data.pedidoPorId.estado.toLowerCase());

                        // Mostrar el método de pago si el pedido no está pagado
                        if (!data.pedidoPorId.pagado) {
                            document.getElementById('metodoTh').style.display = 'table-cell';
                            document.getElementById('metodo').innerText = toTitleCase(data.pedidoPorId
                                .metodo_pago);
                            document.getElementById('metodo').style.display = 'table-cell';
                        } else {
                            document.getElementById('metodoTh').style.display = 'none';
                            document.getElementById('metodo').style.display = 'none';
                        }

                        pedidoDetalles.style.display = 'block';
                    })
                    .catch(error => {
                        console.error('Error al cargar los detalles del pedido:', error);
                    });
            });
        });

        document.querySelectorAll('.formularioEstado').forEach(function(form) {
            form.addEventListener('change', function(event) {
                event.preventDefault();
                var formData = new FormData(this);

                fetch(this.action, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log(data.message);
                        } else {
                            console.error('Error al actualizar el estado del pedido');
                        }
                    })
                    .catch(error => {
                        console.error('Error al actualizar el estado del pedido:', error);
                    });
            });
        });
    </script>
@endsection
