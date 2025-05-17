document.addEventListener('DOMContentLoaded', function() {
    const loginButton = document.querySelector('#btnis a');
    const contLP = document.querySelector('.ContLP');
    const popupIScont = document.querySelector('.popupIScont');
    const overlay = document.querySelector('.overlay');
    const cancelISbtn = document.querySelector('#btnformsalir');
    const checkboxContainer = document.getElementById('mostrarcontracont');
    const inputcontra = document.getElementById('inputcontra');
    const cambiartexto = document.getElementById('cambiartexto');

    loginButton.addEventListener('click', function(event) {
        event.preventDefault();
        contLP.classList.add('blur');
        popupIScont.classList.add('show-popup');
        overlay.classList.add('show');
    });


    function closepopup(){
        overlay.classList.remove('show');
        popupIScont.classList.remove('show-popup');
        contLP.classList.remove('blur');
    }

    overlay.addEventListener('click', function(event){
        event.preventDefault();
        closepopup();
    });

    cancelISbtn.addEventListener('click', function(event){
        event.preventDefault();
        closepopup();
    });


    checkboxContainer.addEventListener('click', function() {
        checkboxContainer.classList.toggle('checked');

        if (inputcontra.type === 'password') {
            inputcontra.type= 'text';

            cambiartexto.textContent = 'Ocultar contraseña';
        }else{
            inputcontra.type='password';

            cambiartexto.textContent = 'Mostrar contraseña';
        }


    });
    
});
