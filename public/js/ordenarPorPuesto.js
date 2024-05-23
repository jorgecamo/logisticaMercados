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
            document.getElementById('tablasPedidos').innerHTML = data;
        })
        .catch(error => {
            console.error('Error al ordenar por puesto:', error);
        });
}