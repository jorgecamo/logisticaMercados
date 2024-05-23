        //Funcion para actualizar el maximo de bultos perecederos segun el numero de bultos

        function actualizarMaximo() {
            var bultos = document.getElementById("bultos").value;
            var bultosPerecederosInput = document.getElementById("bultos_perecederos");

            bultosPerecederosInput.setAttribute("max", bultos);
        }