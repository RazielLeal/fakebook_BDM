// Esperamos a que el DOM esté completamente cargado
document.addEventListener("DOMContentLoaded", function() {
    // Obtenemos el input y la imagen previa
    const fileInput = document.getElementById('mediapp');
    const previewImage = document.getElementById('perfilImagen');

    // Cuando se seleccione un archivo en el input
    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0]; // Obtenemos el primer archivo seleccionado
        
        if (file) {
            const reader = new FileReader();  // Creamos un FileReader para leer el archivo

            reader.onload = function(e) {
                previewImage.src = e.target.result;  // Cambiamos el src de la imagen previa
            };

            reader.readAsDataURL(file);  // Leemos el archivo como una URL de datos
        }
    });
});
