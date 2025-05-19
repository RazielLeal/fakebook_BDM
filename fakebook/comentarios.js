document.querySelectorAll('.comentarioInput').forEach(textarea => {
    textarea.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault(); // Prevenir salto de línea
            const form = this.closest('form');
            form.submit(); // Enviar el formulario
        }
    });
});