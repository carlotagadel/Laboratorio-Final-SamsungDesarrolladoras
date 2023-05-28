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
$apellidoError = "";
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
    $apellidoValido = preg_match('/^[A-Za-z]+$/', $apellido1) && preg_match('/^[A-Za-z]+$/', $apellido2);
    $emailValido = filter_var($email, FILTER_VALIDATE_EMAIL);
    $passValido = (strlen($pass) >= 4 && strlen($pass) <= 8);

    if (!$nombreValido) {
        $nombreError = "El nombre no debe contener números.";
    }
    if (!$apellidoValido) {
        $apellidoError = "Los apellidos no deben contener números.";
    }
    if (!$emailValido) {
        $emailError = "El email ingresado no es válido.";
    }
    if (!$passValido) {
        $passError = "La contraseña debe tener entre 4 y 8 caracteres.";
    }

    if ($nombreValido && $apellidoValido && $emailValido && $passValido) {

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
    <form action="index.php" method="post">

        <h1>Formulario de registro</h1>

        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" required />
        <p id="nombreError" class="error"></p>

        <label for="apellido1">Primer apellido</label>
        <input type="text" name="apellido1" id="apellido1" required />
        <p id="apellidoError" class="error"></p>

        <label for="apellido2">Segundo apellido</label>
        <input type="text" name="apellido2" id="apellido2" required />

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required/>
        <p id="emailError" class="error"></p>

        <label for="login">Login</label>
        <input type="text" name="login" id="login" required/>

        <label for="pass">Contraseña</label>
        <input type="password" name="pass" id="pass" required/>
        <p id="passError" class="error"></p>

        <input class="form-btn" name="submit" type="submit" value="Registrarse" />

        <script>
            document.getElementById('nombre').addEventListener('input', validarNombre);
            document.getElementById('apellido1').addEventListener('input', validarApellidos);
            document.getElementById('apellido2').addEventListener('input', validarApellidos);
            document.getElementById('email').addEventListener('input', validarEmail);
            document.getElementById('pass').addEventListener('input', validarPassword);

            function validarNombre() {
                var nombreInput = document.getElementById('nombre');
                var nombreError = document.getElementById('nombreError');

                if (/^[A-Za-z]+$/.test(nombreInput.value)) {
                    nombreError.textContent = '';
                } else {
                    nombreError.textContent = 'El nombre no debe contener números.';
                }
            }

            function validarApellidos() {
                var apellido1Input = document.getElementById('apellido1');
                var apellido2Input = document.getElementById('apellido2');
                var apellidoError = document.getElementById('apellidoError');

                if (/^[A-Za-z]+$/.test(apellido1Input.value) && /^[A-Za-z]+$/.test(apellido2Input.value)) {
                    apellidoError.textContent = '';
                } else {
                    apellidoError.textContent = 'Los apellidos no deben contener números.';
                }
            }

            function validarEmail() {
                var emailInput = document.getElementById('email');
                var emailError = document.getElementById('emailError');

                if (emailInput.validity.valid) {
                    emailError.textContent = '';
                } else {
                    emailError.textContent = 'El email ingresado no es válido.';
                }
            }

            function validarPassword() {
                var passInput = document.getElementById('pass');
                var passError = document.getElementById('passError');

                if (passInput.value.length >= 4 && passInput.value.length <= 8) {
                    passError.textContent = '';
                } else {
                    passError.textContent = 'La contraseña debe tener entre 4 y 8 caracteres.';
                }
            }
        </script>
    </form>

</body>

</html>