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