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
var inputLine = document.querySelector('.input-line');

nombreInput.addEventListener('input', validaNombre);
apellido1Input.addEventListener('input', validaApellido1);
apellido2Input.addEventListener('input', validaApellido2);
emailInput.addEventListener('input', validaEmail);
loginInput.addEventListener('input', validaLogin);
passInput.addEventListener('input', validaPass);


function validaNombre() {
    var nombreValido = /^[A-Za-z]+$/.test(nombreInput.value);
    var inputLine = document.querySelector('.nombre-input-line');

    if (nombreInput.value === '') {
        nombreError.textContent = 'Por favor, ingresa un nombre.';
        inputLine.classList.add('invalid');
        inputLine.classList.remove('valid');
    } else if (!nombreValido) {
        nombreError.textContent = 'Formato de nombre inválido, por favor revísalo.';
        inputLine.classList.add('invalid');
        inputLine.classList.remove('valid');
    } else {
        nombreError.textContent = '';
        inputLine.classList.remove('invalid');
        inputLine.classList.add('valid');
    }
}

function validaApellido1() {
    var apellido1Valido = /^[A-Za-záéíóúÁÉÍÓÚüÜ]+$/.test(apellido1Input.value);
    var inputLine = document.querySelector('.apellido1-input-line');

    if (apellido1Input.value === '') {
        apellido1Error.textContent = 'Por favor, ingresa un primer apellido.';
        inputLine.classList.add('invalid');
        inputLine.classList.remove('valid');
    } else if (!apellido1Valido) {
        apellido1Error.textContent = 'Formato de apellido inválido, por favor revísalo.';
        inputLine.classList.add('invalid');
        inputLine.classList.remove('valid');
    } else {
        apellido1Error.textContent = '';
        inputLine.classList.remove('invalid');
        inputLine.classList.add('valid');
    }
}

function validaApellido2() {
    var apellido2Valido = /^[A-Za-záéíóúÁÉÍÓÚüÜ]+$/.test(apellido2Input.value);
    var inputLine = document.querySelector('.apellido2-input-line');


    if (apellido2Input.value === '') {
        apellido2Error.textContent = 'Por favor, ingresa un segundo apellido.';
        inputLine.classList.add('invalid');
        inputLine.classList.remove('valid');
    } else if (!apellido2Valido) {
        apellido2Error.textContent = 'Formato de apellido inválido, por favor revísalo.';
        inputLine.classList.add('invalid');
        inputLine.classList.remove('valid');
    } else {
        apellido2Error.textContent = '';
        inputLine.classList.remove('invalid');
        inputLine.classList.add('valid');
    }
}

function validaEmail() {
    var emailValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value);
    var inputLine = document.querySelector('.email-input-line');

    if (emailInput.value === '') {
        emailError.textContent = 'Por favor, ingresa un email.';
        inputLine.classList.add('invalid');
        inputLine.classList.remove('valid');
    } else if (!emailValido) {
        emailError.textContent = 'Formato de email inválido, por favor revísalo.';
        inputLine.classList.add('invalid');
        inputLine.classList.remove('valid');
    } else {
        emailError.textContent = '';
        inputLine.classList.remove('invalid');
        inputLine.classList.add('valid');
    }
}

function validaLogin() {
    var loginInputValue = loginInput.value;
    var inputLine = document.querySelector('.login-input-line');

    if (loginInputValue === '') {
        loginError.textContent = 'Por favor, ingresa un login.';
        inputLine.classList.remove('valid');
        inputLine.classList.add('invalid');
    } else {
        loginError.textContent = '';
        inputLine.classList.remove('invalid');
        inputLine.classList.add('valid');
    }
}

function validaPass() {
    var passValido = /^.{4,8}$/.test(passInput.value);
    var inputLine = document.querySelector('.pass-input-line');

    if (passInput.value === '') {
        passError.textContent = 'Por favor, ingresa una contraseña.';
        inputLine.classList.add('invalid');
        inputLine.classList.remove('valid');
    } else if (!passValido) {
        passError.textContent = 'La contraseña debe tener entre 4 y 8 caracteres.';
        inputLine.classList.add('invalid');
        inputLine.classList.remove('valid');
    } else {
        passError.textContent = '';
        inputLine.classList.remove('invalid');
        inputLine.classList.add('valid');
    }
}

document.getElementById('registroForm').addEventListener('submit', function (event) {
    validaNombre();
    validaApellido1();
    validaApellido2();
    validaEmail();
    validaLogin();
    validaPass();

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