var nombreInput = document.getElementById('nombre');
var apellido1Input = document.getElementById('apellido1');
var apellido2Input = document.getElementById('apellido2');
var emailInput = document.getElementById('email');
var passInput = document.getElementById('pass');

var nombreError = document.querySelector('input[name="nombre"] + p.error');
var apellido1Error = document.querySelector('input[name="apellido1"] + p.error');
var apellido2Error = document.querySelector('input[name="apellido2"] + p.error');
var emailError = document.querySelector('input[name="email"] + p.error');
var passError = document.querySelector('input[name="pass"] + p.error');

nombreInput.addEventListener('input', validarNombre);
apellido1Input.addEventListener('input', validarApellido1);
apellido2Input.addEventListener('input', validarApellido2);
emailInput.addEventListener('input', validarEmail);
passInput.addEventListener('input', validarPass);


function validarNombre() {
    var nombreValido = /^[A-Za-z]+$/.test(nombreInput.value);

    if (nombreInput.value === '') {
        nombreError.textContent = 'Debes ingresar un nombre.';
    } else if (!nombreValido) {
        nombreError.textContent = 'El nombre no debe contener números.';
    } else {
        nombreError.textContent = '';
    }
}


function validarApellido(apellido) {
    var apellidoValido = /^[A-Za-záéíóúÁÉÍÓÚüÜ]+$/.test(apellido);

    if (!apellidoValido) {
        return 'Los apellidos no deben contener números y no pueden estar vacíos.';
    } else {
        return '';
    }
}

function validarApellido1() {
    apellido1Error.textContent = validarApellido(apellido1Input.value);
    if (apellido1Input.value === '') {
        apellido1Error.textContent = 'Debes ingresar un primer apellido.';
    }
}

function validarApellido2() {
    apellido2Error.textContent = validarApellido(apellido2Input.value);
    if (apellido2Input.value === '') {
        apellido2Error.textContent = 'Debes ingresar un segundo apellido.';
    }
}

function validarEmail() {
    var emailValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value);

    if (emailInput.value === '') {
        emailError.textContent = 'Debes ingresar un email.';
    } else if (!emailValido) {
        emailError.textContent = 'El email ingresado no es válido.';
    } else {
        emailError.textContent = '';
    }
}

function validarPass() {
    var passValido = /^[A-Za-z0-9]{4,8}$/.test(passInput.value);

    if (passInput.value === '') {
        passError.textContent = 'Debes ingresar una contraseña.';
    } else if (!passValido) {
        passError.textContent = 'La contraseña debe tener entre 4 y 8 caracteres alfanuméricos.';
    } else {
        passError.textContent = '';
    }
}

document.getElementById('registroForm').addEventListener('submit', function (event) {
    validarNombre();
    validarApellido1();
    validarApellido2();
    validarEmail();
    validarPass();

    if (!nombreError.textContent && !apellido1Error.textContent && !apellido2Error.textContent && !emailError.textContent && !passError.textContent) {
        return;
    }

    event.preventDefault();
});