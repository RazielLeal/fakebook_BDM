document.getElementById("media").addEventListener("change", function(event) {
    const file = event.target.files[0];  // ya que ahora solo se acepta un archivo
    const previewContainer = document.getElementById("imgContainer");
    
    // Si no se selecciona ningún archivo, no se hace nada
    if (!file) {
        return;
    }
    
    const reader = new FileReader();
    
    reader.onload = function(e) {
        // Dependiendo de si el archivo es imagen o video, crea el elemento adecuado
        const mediaElement = document.createElement(file.type.startsWith("image") ? "img" : "video");
        mediaElement.src = e.target.result;
        mediaElement.classList.add("previewMedia");
        
        // Si es video, activar controles
        if (file.type.startsWith("video")) {
            mediaElement.controls = true;
        }
        
        // Limpiar el contenedor y mostrar la vista previa del archivo seleccionado
        previewContainer.innerHTML = "";
        previewContainer.appendChild(mediaElement);
    };
    
    // Leer el archivo como URL de datos (base64)
    reader.readAsDataURL(file);
});