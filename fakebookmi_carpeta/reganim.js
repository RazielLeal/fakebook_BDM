const inputREGncontra = document.getElementById("inputREGncontra");
const checkboxContainer = document.getElementById('mostrarcontracont');
const cambiartexto = document.getElementById('cambiartexto');

checkboxContainer.addEventListener('click', function() {
    checkboxContainer.classList.toggle('checked');

    if (inputREGncontra.type === 'password') {
        inputREGncontra.type= 'text';

        cambiartexto.textContent = 'Ocultar contraseña';
    }else{
        inputREGncontra.type='password';

        cambiartexto.textContent = 'Mostrar contraseña';
    }


});
