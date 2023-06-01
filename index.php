<?php
require_once 'config.php';
require_once 'functions.php';

$nombreError = $apellido1Error = $apellido2Error = $emailError = $passError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido1 = $_POST['apellido1'] ?? '';
    $apellido2 = $_POST['apellido2'] ?? '';
    $email = $_POST['email'] ?? '';
    $login = $_POST['login'] ?? '';
    $pass = $_POST['pass'] ?? '';

    $nombreValido = validarNombre($nombre);
    $apellidoValido = validarApellidos($apellido1, $apellido2);
    $emailValido = validarEmail($email);
    $passValido = validarContraseña($pass);

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

        try {

            $conn = conectarDB();

            $emailExiste = verificarEmailExistente($conn, $email);

            if ($emailExiste) {
                cerrarConexion($conn);
                echo "<script>alert('El email ingresado ya está registrado.'); location.href = 'index.php';</script>"; //usando header( "Location: {$_SERVER['REQUEST_URI']}", true, 303 ); se me reinicia la página antes de que aparezca el mensaje, por lo que he optado por otro método
                exit;
            }

            $registroExitoso = insertarUsuario($conn, $nombre, $apellido1, $apellido2, $email, $login, $pass);

            if ($registroExitoso) {
                $_SESSION['acceso_autorizado'] = true;
                cerrarConexion($conn);
                header("Location: exito.php");
                exit;
            }

            echo "Error al registrar los datos en la base de datos.";
            cerrarConexion($conn);
            exit;

        } catch (mysqli_sql_exception $e) {
            echo "Error de base de datos: " . $e->getMessage();
        }
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

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" />
        <p class="error">
            <?php echo $nombreError; ?>
        </p>

        <label for="apellido1">Primer apellido:</label>
        <input type="text" name="apellido1" id="apellido1" />
        <p class="error">
            <?php echo $apellido1Error; ?>
        </p>

        <label for="apellido2">Segundo apellido:</label>
        <input type="text" name="apellido2" id="apellido2" />
        <p class="error">
            <?php echo $apellido2Error; ?>
        </p>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" />
        <p class="error">
            <?php echo $emailError; ?>
        </p>

        <label for="login">Login:</label>
        <input type="text" name="login" id="login" />

        <label for="pass">Contraseña:</label>
        <input type="password" name="pass" id="pass" />
        <p class="error">
            <?php echo $passError; ?>
        </p>

        <input class="form-btn" name="submit" type="submit" value="Registrarse" />

    </form>

    <script src="script.js"></script>

</body>

</html>