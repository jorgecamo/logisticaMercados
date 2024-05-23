@extends('plantillaVendedor')
@section('titulo', 'Añadir_Pedido')
@section('contenido')

@php
$clientes = session('clientes');
$Id_usuario = session('Id_usuario');
@endphp

<p class="mb-4 fs-2 fw-bold text-center">Crear Pedido</p>
    <form class="formularioPedido" action="{{ route('vendedor.store') }}" method="post">
        @csrf
        <input type="hidden" name="id_usuario" value="{{ $Id_usuario }}">
        <div class="form-group">
            <label for="id_cliente"  class="fs-3 fw-bold">Cliente:</label>
            <select class="form-control" name="id_cliente" id="id_cliente" required>
                <option value="">--Porfavor selecciona una opcion--</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->Id_cliente }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-4">
            <label for="direccion"  class="fs-3 fw-bold">Direcciones:</label>
            <select class="form-control" name="direccion" id="direccion">
                <option value="">No tiene direcciones</option>
            </select>
        </div>

        <div class="from-group mt-4">
            <label for="bultos"  class="fs-3 fw-bold">Numero de bultos:</label>
            <input type="number" class="form-control" id="bultos" name="bultos" min="1" step="1" max="10"
                onchange="actualizarMaximo()" value="1">
            <label for="bultos_perecederos"  class="fs-3 fw-bold">Bultos perecederos:</label>
            <input type="number" class="form-control" id="bultos_perecederos" name="bultos_perecederos" min="0" step="1"
                max="10" value="0">
        </div>
        <div class="from-group mt-4">
            <label for="pagado"  class="fs-3 fw-bold">Pagado:</label>
            <input type="checkbox"  id="pagado" name="pagado" value="true" checked>

            <div class="metodos_pago mt-4" id="metodos_pago" style="display: none" >
                <label for="efectivo"  class="fs-3 fw-bold">Efectivo:</label>
                <input type="radio" id="efectivo" name="metodo_pago" value="efectivo" checked>
                <label for="tarjeta"  class="fs-3 fw-bold">Tarjeta:</label>
                <input type="radio" id="tarjeta" name="metodo_pago" value="tarjeta">
            </div>

        </div>
        <div class="from-group mt-4">
            <label for="total_pedido"  class="fs-3 fw-bold">Cantidad total del pedido:</label>
            <input type="number" class="form-control" id="total_pedido" name="total_pedido" min="0" step="1">
        </div>



        <div class="botones mt-4 text-center">
            <button type="submit" class="btn me-5" style="background-color: #009483; color:#ffffff">Enviar</button>
            <button type="reset" class="btn" style="background-color: #006358; color:#ffffff">Borrar</button>
        </div>
    </form>
    @if($errors->any())
    <div class="alert alert-danger">
        {{$errors->first('error')}}
    </div>
    @endif


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#pagado').change(function() {
                if ($(this).is(":checked")) {
                    $('#metodos_pago').hide();
                } else {
                    $('#metodos_pago').show();
                }
            });
        });

        function actualizarMaximo() {
            var bultos = document.getElementById("bultos").value;
            var bultosPerecederosInput = document.getElementById("bultos_perecederos");

            bultosPerecederosInput.setAttribute("max", bultos);
        }

        $(document).ready(function() {
            $('#id_cliente').change(function() {
                var Id_cliente = $(this).val();
                $.ajax({
                    url: '/clientes/' +
                        Id_cliente, // Corregido a '/clientes/' en lugar de '/cliente.show/'
                    type: 'GET',
                    success: function(response) {
                        $('#direccion').empty();
                        if (response.direcciones.length === 0) {
                            $('#direccion').append(
                                '<option value="">No tiene direcciones</option>');
                        } else {
                            $.each(response.direcciones, function(key, value) {
                                $('#direccion').append('<option value="' + value
                                    .direcciones + '">' + value.direcciones +
                                    '</option>');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
