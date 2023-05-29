<?php
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "cursosql";

$nombreError = $apellido1Error = $apellido2Error = $emailError = $passError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido1 = $_POST['apellido1'] ?? '';
    $apellido2 = $_POST['apellido2'] ?? '';
    $email = $_POST['email'] ?? '';
    $login = $_POST['login'] ?? '';
    $pass = $_POST['pass'] ?? '';

    $nombreValido = preg_match('/^[A-Za-z]+$/', $nombre);
    $apellidoValido = preg_match('/^[A-Za-záéíóúÁÉÍÓÚüÜ]+$/', $apellido1) && preg_match('/^[A-Za-záéíóúÁÉÍÓÚüÜ]+$/', $apellido2);
    $emailValido = filter_var($email, FILTER_VALIDATE_EMAIL);
    $passValido = (strlen($pass) >= 4 && strlen($pass) <= 8);

    if (!$nombreValido) {
        $nombreError = "El nombre no debe contener números.";
    }
    if (!$apellidoValido) {
        $apellido1Error = $apellido2Error = "Los apellidos no deben contener números.";
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
    <form action="index.php" method="post" id="registroForm">

        <h1>Formulario de registro</h1>

        <label for="nombre">Nombre*</label>
        <input type="text" name="nombre" id="nombre" />
        <p class="error">
            <?php echo $nombreError; ?>
        </p>

        <label for="apellido1">Primer apellido*</label>
        <input type="text" name="apellido1" id="apellido1" />
        <p class="error">
            <?php echo $apellido1Error; ?>
        </p>

        <label for="apellido2">Segundo apellido*</label>
        <input type="text" name="apellido2" id="apellido2" />
        <p class="error">
            <?php echo $apellido2Error; ?>
        </p>

        <label for="email">Email*</label>
        <input type="email" name="email" id="email" />
        <p class="error">
            <?php echo $emailError; ?>
        </p>

        <label for="login">Login*</label>
        <input type="text" name="login" id="login" />

        <label for="pass">Contraseña*</label>
        <input type="password" name="pass" id="pass" />
        <p class="error">
            <?php echo $passError; ?>
        </p>

        <input class="form-btn" name="submit" type="submit" value="Registrarse" />

        <script>
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

                if (passInput.value === ''){
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
        </script>
    </form>
</body>

</html>