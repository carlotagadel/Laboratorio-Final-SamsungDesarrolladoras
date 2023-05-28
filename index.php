<?php
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "cursosql";

$nombre = "";
$apellido1 = "";
$apellido2 = "";
$email = "";
$login = "";
$pass = "";
$nombreError = "";
$apellido1Error = "";
$apellido2Error = "";
$emailError = "";
$passError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $apellido1 = isset($_POST['apellido1']) ? $_POST['apellido1'] : '';
    $apellido2 = isset($_POST['apellido2']) ? $_POST['apellido2'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $login = isset($_POST['login']) ? $_POST['login'] : '';
    $pass = isset($_POST['pass']) ? $_POST['pass'] : '';

    $nombreValido = preg_match('/^[A-Za-z]+$/', $nombre);
    $apellidoValido1 = preg_match('/^[A-Za-z]+$/', $apellido1);
    $apellidoValido2 = preg_match('/^[A-Za-z]+$/', $apellido2);
    $emailValido = filter_var($email, FILTER_VALIDATE_EMAIL);
    $passValido = (strlen($pass) >= 4 && strlen($pass) <= 8);

    if (!$nombreValido) {
        $nombreError = "El nombre no debe contener números.";
    }
    if (!$apellidoValido1) {
        $apellido1Error = "Los apellidos no deben contener números.";
    }
    if (!$apellidoValido2) {
        $apellido2Error = "Los apellidos no deben contener números.";
    }
    if (!$emailValido) {
        $emailError = "El email ingresado no es válido.";
    }
    if (!$passValido) {
        $passError = "La contraseña debe tener entre 4 y 8 caracteres.";
    }

    if ($nombreValido && $apellidoValido1 && $apellidoValido2 && $emailValido && $passValido) {

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $emailExiste = false;
        $sqlVerificar = "SELECT * FROM usuarios_formulario WHERE email='$email'";
        $result = $conn->query($sqlVerificar);

        if ($result->num_rows > 0) {

            $emailExiste = true;
            echo "El email ingresado ya está registrado.";
            header("Location: index.php");
            $conn->close();
            exit;
        }

        $sqlInsertar = "INSERT INTO usuarios_formulario (NOMBRE, PRIMER_APELLIDO, SEGUNDO_APELLIDO, EMAIL, LOG_IN, CONTRASEÑA) VALUES ('$nombre', '$apellido1', '$apellido2', '$email', '$login', '$pass')";

        if ($conn->query($sqlInsertar) === TRUE) {
            header("Location: exito.php");
            $conn->close();
            exit;

        }

        echo "Error al registrar los datos en la base de datos: " . $conn->error;
        header("Location: index.php");
        $conn->close();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ES">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratorio Samsung Desarrolladoras</title>
    <link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
    <form action="index.php" method="post" id="registroForm">

        <h1>Formulario de registro</h1>

        <label for="nombre">Nombre*</label>
        <input type="text" name="nombre" id="nombre" />
        <p id="nombreError" class="error"></p>

        <label for="apellido1">Primer apellido*</label>
        <input type="text" name="apellido1" id="apellido1" />
        <p id="apellido1Error" class="error"></p>

        <label for="apellido2">Segundo apellido*</label>
        <input type="text" name="apellido2" id="apellido2" />
        <p id="apellido2Error" class="error"></p>

        <label for="email">Email*</label>
        <input type="email" name="email" id="email" />
        <p id="emailError" class="error"></p>

        <label for="login">Login*</label>
        <input type="text" name="login" id="login" />

        <label for="pass">Contraseña*</label>
        <input type="password" name="pass" id="pass" />
        <p id="passError" class="error"></p>

        <input class="form-btn" name="submit" type="submit" value="Registrarse" />

        <script>
            var nombreInput = document.getElementById('nombre');
            var apellido1Input = document.getElementById('apellido1');
            var apellido2Input = document.getElementById('apellido2');
            var emailInput = document.getElementById('email');
            var passInput = document.getElementById('pass');

            var nombreError = document.getElementById('nombreError');
            var apellido1Error = document.getElementById('apellido1Error');
            var apellido2Error = document.getElementById('apellido2Error');
            var emailError = document.getElementById('emailError');
            var passError = document.getElementById('passError');

            nombreInput.addEventListener('input', validarNombre);
            apellido1Input.addEventListener('input', validarApellido1);
            apellido2Input.addEventListener('input', validarApellido2);
            emailInput.addEventListener('input', validarEmail);
            passInput.addEventListener('input', validarPass);

            function validarNombre() {
                var nombreValido = /^[A-Za-z]+$/.test(nombreInput.value);

                if (!nombreValido) {
                    nombreError.textContent = 'El nombre no debe contener números.';
                } else {
                    nombreError.textContent = '';
                }
            }

            function validarApellido(apellido) {
                var apellidoValido = /^[A-Za-z]+$/.test(apellido);

                if (!apellidoValido) {
                    return 'El apellido no debe contener números y no puede estar vacío.';
                } else {
                    return '';
                }
            }

            function validarApellido1() {

                apellido1Error.textContent = validarApellido(apellido1Input.value)

            }

            function validarApellido2() {

                apellido2Error.textContent = validarApellido(apellido2Input.value)

            }

            function validarEmail() {
                
                var email = emailInput.value.trim(); // Eliminar espacios en blanco al inicio y al final
                var emailValido = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(email);

                if (email === '') {
                    emailError.textContent = 'Debes ingresar un email.';
                } else if (!emailValido) {
                    emailError.textContent = 'El email ingresado no es válido.';
                } else {
                    emailError.textContent = '';
                }
            }

            function validarPass() {
                var passValido = /^.{4,8}$/.test(passInput.value);

                if (!passValido) {
                    passError.textContent = 'La contraseña debe tener entre 4 y 8 caracteres.';
                } else {
                    passError.textContent = '';
                }
            }

            registroForm.addEventListener('submit', function (event) {
                validarNombre();
                validarApellido1();
                validarApellido2();
                validarEmail();
                validarPass();

                var errores = document.querySelectorAll('.error');

                if (errores.length > 0) {
                    event.preventDefault();
                }
            });
        </script>
    </form>

</body>

</html>