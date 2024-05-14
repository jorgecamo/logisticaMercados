@extends('plantillaVendedor')
@section('titulo', 'Inicio')
@section('contenido')

    <form class="formularioPedido" action="{{ route('vendedor.store') }}" method="post">
        @csrf
        <input type="hidden" name="id_usuario" value="{{ $Id_usuario }}">
        <div class="form-group">
            <label for="id_cliente">Cliente:</label>
            <select class="form-control" name="id_cliente" id="id_cliente" required>
                <option value="">--Porfavor selecciona una opcion--</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->Id_cliente }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="direccion">Direcciones:</label>
            <select class="form-control" name="direccion" id="direccion">

            </select>
        </div>

        <div class="from-group">
            <label for="total_pedido">Cantidad total del pedido:</label>
            <input type="number" id="total_pedido" name="total_pedido" min="0" step="1">
        </div>

        <div class="from-group">
            <label for="pagado">Pagado:</label>
            <input type="checkbox" id="pagado" name="pagado" value="true">
            <label for="perecedero">Perecedero:</label>
            <input type="checkbox" id="perecedero" name="perecedero" value="true">

            <div class="metodos_pago" id="metodos_pago">
                <label for="efectivo">Efectivo:</label>
                <input type="radio" id="efectivo" name="metodo_pago" value="efectivo">
                <label for="tarjeta">Tarjeta:</label>
                <input type="radio" id="tarjeta" name="metodo_pago" value="tarjeta">
            </div>

        </div>

        <div class="botones">
            <button type="submit" class="btn btn-primary">Enviar</button>
            <button type="reset" class="btn btn-danger">Borrar</button>
        </div>
    </form>

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
                                $('#direccion').append('<option value="' + value.direcciones + '">' + value.direcciones +
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
