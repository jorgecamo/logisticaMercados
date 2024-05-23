//Aqui genero el mapa de google maps para la mejor ruta, cojo las direcciones de los pedidos con la misma franja horaria
$(document).on('click', '.generarRuta', function(event) {
    event.preventDefault();
    let franjaHoraria = $(this).data('franja');
    let pedidos = [];

    $('td.franja').each(function() {
        if ($(this).text() === franjaHoraria) {
            let direccion = $(this).siblings('.direccion').text();
            let localidad = $(this).siblings('.localidad').text();
            pedidos.push({
                direccion: direccion + ', ' + localidad,
            });
        }
    });
    let mercado = $('#direccionMercado').text();
    let url = "https://www.google.com/maps/dir/" + encodeURIComponent(mercado) + "/";
    pedidos.forEach(pedido => {
        url += encodeURIComponent(pedido.direccion) + "/";
    });

    window.open(url, '_blank');
});