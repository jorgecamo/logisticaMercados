        //Funcion para cambiar el metodo pago
        $(document).ready(function() {
            $('#pagado').change(function() {
                if ($(this).is(":checked")) {
                    $('#metodos_pago').hide();
                } else {
                    $('#metodos_pago').show();
                }
            });
        });