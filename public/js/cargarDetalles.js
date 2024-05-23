var verMas = false; // Variable para actualizar la vista del pedido si se ha clickado ver mas en algun momento


document.addEventListener('DOMContentLoaded', function() {
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
        formularioFecha.submit();
        localStorage.setItem('formularioEnviado', true);
    }
    //Funcion para que se ejecute el formulario fecha con el boton submit
    formularioFecha.addEventListener('submit', function(event) {
        event.preventDefault();
        this.submit();
    });

    if (!formularioEnviado) {
        enviarFormulario();
    }

    var pedidosContainer = document.getElementById('pedidos-container');
    var urlBase = pedidosContainer.getAttribute('data-url');

    // funcion ver mas del pedido y aparece los datos del pedido y del cliente 
    document.querySelectorAll('.ver-mas').forEach(function(element) {
        element.addEventListener('click', function(event) {
            event.preventDefault();
            var pedidoId = this.getAttribute('data-pedido');
            var pedidoDetalles = document.getElementById('detallesPedido');
            var datosCliente = document.getElementById('datosCliente');

            fetch(urlBase.replace(':id', pedidoId))
                .then(response => response.json())
                .then(data => {
                    verMas = true;
                    // Datos de la lista detalle cliente
                    document.getElementById('nombreCliente').innerText = data.datosCliente.nombre;
                    document.getElementById('dniCliente').innerText = data.datosCliente.DNI;
                    document.getElementById('direccionCliente').innerText = data.pedidoPorId.direccion;
                    document.getElementById('telefonoCliente').innerText = data.datosCliente.telefono;

                    // Datos de la tabla detalles pedido
                    document.getElementById('usuario').innerText = data.usuarioQueRealizaElPedido.nombre;
                    document.getElementById('total').innerText = data.pedidoPorId.total_pedido + " €";
                    document.getElementById('pagado').innerText = data.pedidoPorId.pagado ? "Sí" : "No";
                    document.getElementById('bultos').innerText = data.pedidoPorId.bultos;
                    document.getElementById('fecha_pedido').innerText = formatearFecha(data.pedidoPorId.fecha_pedido);
                    document.getElementById('franja_horaria').innerText = data.pedidoPorId.franja_horaria;

                    if (!data.pedidoPorId.bultos_perecederos) {
                        document.getElementById('bultos_perecederosTh').style.display = 'none';
                        document.getElementById('bultos_perecederos').style.display = 'none';
                    } else {
                        document.getElementById('bultos_perecederosTh').style.display = 'table-cell';
                        document.getElementById('bultos_perecederos').innerText = data.pedidoPorId.bultos_perecederos;
                        document.getElementById('bultos_perecederos').style.display = 'table-cell';
                    }

                    document.getElementById('estado').innerText = data.estadoPedido.estados.replace(/_/g, ' ');

                    var estadoTd = document.getElementById('estado');
                    estadoTd.className = ''; 
                    estadoTd.classList.add('estado-' + data.estadoPedido.estados.toLowerCase().replace(/_/g, ''));

                    // Mostrar el método de pago si el pedido no está pagado
                    if (!data.pedidoPorId.pagado) {
                        document.getElementById('metodoTh').style.display = 'table-cell';
                        document.getElementById('metodo').innerText = toTitleCase(data.metodoPagoPedido.metodo_pago);
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
});
