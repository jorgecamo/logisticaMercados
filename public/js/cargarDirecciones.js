        //Funcion para cargar las direcciones del cliente seleccionado en el select

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