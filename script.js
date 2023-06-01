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
        nombreInput.classList.add('invalid');
    } else if (!nombreValido) {
        nombreError.textContent = 'El nombre no debe contener números.';
        nombreInput.classList.add('invalid');
    } else {
        nombreError.textContent = '';
        nombreInput.classList.remove('invalid');
    }
}

function validarApellido1() {
    var apellido1Valido = /^[A-Za-záéíóúÁÉÍÓÚüÜ]+$/.test(apellido1Input);

    if (apellido1Input.value === '') {
        apellido1Error.textContent = 'Debes ingresar un primer apellido.';
        apellido1Input.classList.add('invalid');
    } else if (!apellido1Valido) {
        apellido1Error.textContent = 'El apellido no debe contener números.';
        apellido1Input.classList.add('invalid');
    } else {
        apellido1Error.textContent = '';
        apellido1Input.classList.remove('invalid');
    }
}

function validarApellido2() {
    var apellidoValido = /^[A-Za-záéíóúÁÉÍÓÚüÜ]+$/.test(apellido2Input);

    if (apellido2Input.value === '') {
        apellido2Error.textContent = 'Debes ingresar un segundo apellido.';
        apellido2Input.classList.add('invalid');
    } else if (!apellidoValido) {
        apellido2Error.textContent = 'El apellido no debe contener números.';
        apellido2Input.classList.add('invalid');
    } else {
        apellido2Error.textContent = '';
        apellido2Input.classList.remove('invalid');
    }
}

function validarEmail() {
    var emailValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value);

    if (emailInput.value === '') {
        emailError.textContent = 'Debes ingresar un email.';
        emailInput.classList.add('invalid');
    } else if (!emailValido) {
        emailError.textContent = 'El email ingresado no es válido.';
        emailInput.classList.add('invalid');
    } else {
        emailError.textContent = '';
        emailInput.classList.remove('invalid');
    }
}

function validarPass() {
    var passValido = /^[A-Za-z0-9]{4,8}$/.test(passInput.value);

    if (passInput.value === '') {
        passError.textContent = 'Debes ingresar una contraseña.';
        passInput.classList.add('invalid');
    } else if (!passValido) {
        passError.textContent = 'La contraseña debe tener entre 4 y 8 caracteres alfanuméricos.';
        passInput.classList.add('invalid');
    } else {
        passError.textContent = '';
        passInput.classList.remove('invalid');
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