document.addEventListener('DOMContentLoaded', function() {
    // Seleccionar todos los botones de guardar
    const botonesGuardar = document.querySelectorAll('.btnGuardar');
    
    // Añadir evento de clic a cada botón
    botonesGuardar.forEach(boton => {
        boton.addEventListener('click', function() {
            // Obtener el ID de la publicación del atributo data
            const publicacionId = this.getAttribute('data-publicacion_id');
            
            // Crear un objeto FormData para enviar los datos
            const formData = new FormData();
            formData.append('publicacion_id', publicacionId);
            
            // Realizar la solicitud AJAX
            fetch('guardar.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Si la operación fue exitosa
                    // Verificar el mensaje para saber si se guardó o se eliminó
                    if (data.message.includes('guardada')) {
                        // Si se guardó, cambiar el aspecto del botón
                        this.textContent = '✅ Guardado';
                        this.classList.add('guardado');
                    } else {
                        // Si se eliminó, restaurar el botón
                        this.textContent = '🗂️ Guardar';
                        this.classList.remove('guardado');
                    }
                } else {
                    // Si hubo un error, mostrar el mensaje de error
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al guardar la publicación');
            });
        });
    });
});