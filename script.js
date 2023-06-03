var nombreInput = document.getElementById('nombre');
var apellido1Input = document.getElementById('apellido1');
var apellido2Input = document.getElementById('apellido2');
var emailInput = document.getElementById('email');
var loginInput = document.getElementById('login');
var passInput = document.getElementById('pass');

var nombreError = document.querySelector('input[name="nombre"] + p.error');
var apellido1Error = document.querySelector('input[name="apellido1"] + p.error');
var apellido2Error = document.querySelector('input[name="apellido2"] + p.error');
var emailError = document.querySelector('input[name="email"] + p.error');
var loginError = document.querySelector('input[name="login"] + p.error');
var passError = document.querySelector('input[name="pass"] + p.error');

nombreInput.addEventListener('input', validarNombre);
apellido1Input.addEventListener('input', validarApellido1);
apellido2Input.addEventListener('input', validarApellido2);
emailInput.addEventListener('input', validarEmail);
loginInput.addEventListener('input', validarLogin);
passInput.addEventListener('input', validarPass);


function validarNombre() {
    var nombreValido = /^[A-Za-z]+$/.test(nombreInput.value);

    if (nombreInput.value === '') {
        nombreError.textContent = 'Por favor, ingresa un nombre.';
        nombreInput.classList.add('invalid');
        nombreInput.classList.remove('valid');
    } else if (!nombreValido) {
        nombreError.textContent = 'El nombre no puede contener números.';
        nombreInput.classList.add('invalid');
        nombreInput.classList.remove('valid');
    } else {
        nombreError.textContent = '';
        nombreInput.classList.remove('invalid');
        nombreInput.classList.add('valid');
    }
}

function validarApellido1() {
    var apellido1Valido = /^[A-Za-záéíóúÁÉÍÓÚüÜ]+$/.test(apellido1Input.value);

    if (apellido1Input.value === '') {
        apellido1Error.textContent = 'Por favor, ingresa un primer apellido.';
        apellido1Input.classList.add('invalid');
    } else if (!apellido1Valido) {
        apellido1Error.textContent = 'El apellido no puede contener números.';
        apellido1Input.classList.add('invalid');
    } else {
        apellido1Error.textContent = '';
        apellido1Input.classList.remove('invalid');
    }
}

function validarApellido2() {
    var apellido2Valido = /^[A-Za-záéíóúÁÉÍÓÚüÜ]+$/.test(apellido2Input.value);

    if (apellido2Input.value === '') {
        apellido2Error.textContent = 'Por favor, ingresa un segundo apellido.';
        apellido2Input.classList.add('invalid');
    } else if (!apellido2Valido) {
        apellido2Error.textContent = 'El apellido no puede contener números.';
        apellido2Input.classList.add('invalid');
    } else {
        apellido2Error.textContent = '';
        apellido2Input.classList.remove('invalid');
    }
}

function validarEmail() {
    var emailValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value);

    if (emailInput.value === '') {
        emailError.textContent = 'Por favor, ingresa un email.';
        emailInput.classList.add('invalid');
    } else if (!emailValido) {
        emailError.textContent = 'El email ingresado no es válido.';
        emailInput.classList.add('invalid');
    } else {
        emailError.textContent = '';
        emailInput.classList.remove('invalid');
    }
}

function validarLogin() {
    var loginValido = /^[A-Za-z0-9]{3,10}$/.test(loginInput.value);

    if (loginInput.value === '') {
        loginError.textContent = 'Por favor, ingresa un login.';
        loginInput.classList.add('invalid');
    } else if (!loginValido) {
        loginError.textContent = 'El login debe tener entre 3 y 10 caracteres alfanuméricos.';
        loginInput.classList.add('invalid');
    } else {
        loginError.textContent = '';
        loginInput.classList.remove('invalid');
    }
}

function validarPass() {
    var passValido = /^[A-Za-z0-9]{4,8}$/.test(passInput.value);

    if (passInput.value === '') {
        passError.textContent = 'Por favor, ingresa una contraseña.';
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
    validarLogin();
    validarPass();

    if (
        !nombreError.textContent &&
        !apellido1Error.textContent &&
        !apellido2Error.textContent &&
        !emailError.textContent &&
        !loginError.textContent &&
        !passError.textContent
    ) {
        return;
    }

    event.preventDefault();
});