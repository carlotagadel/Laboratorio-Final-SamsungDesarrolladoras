<?php
session_start();

require_once 'config/config.php';
require_once 'utils/functions.php';

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");


$nombreError = $apellido1Error = $apellido2Error = $emailError = $loginError = $passError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido1 = $_POST['apellido1'] ?? '';
    $apellido2 = $_POST['apellido2'] ?? '';
    $email = $_POST['email'] ?? '';
    $login = $_POST['login'] ?? '';
    $pass = $_POST['pass'] ?? '';

    if (!camposRellenados($nombre, $apellido1, $apellido2, $email, $login, $pass)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    $nombreValido = validarNombre($nombre);
    $apellidoValido = validarApellidos($apellido1, $apellido2);
    $emailValido = validarEmail($email);
    $loginValido = validarLogin($login);
    $passValido = validarContraseña($pass);

    if (!$nombreValido) {
        $nombreError = "El nombre no debe contener números.";
    }
    if (!$apellidoValido) {
        $apellido1Error = "El primer apellido no debe contener números.";
        $apellido2Error = "El segundo apellido no debe contener números.";
    }
    if (!$emailValido) {
        $emailError = "El email ingresado no es válido.";
    }
    if (!$loginValido) {
        $loginError = "El login debe tener entre 3 y 10 caracteres.";
    }
    if (!$passValido) {
        $passError = "La contraseña debe tener entre 4 y 8 caracteres.";
    }

    if ($nombreValido && $apellidoValido && $emailValido && $loginValido && $passValido) {
        try {
            $conn = conectarDB();

            if (!$conn) {
                echo "Error al conectar a la base de datos.";
                exit;
            }

            $emailExiste = verificarEmailExistente($conn, $email);

            if ($emailExiste) {
                cerrarConexion($conn);
                echo "<script>alert('El email ingresado ya está registrado.'); location.href = 'index.php';</script>";
                exit;
            }

            $registroExitoso = insertarUsuario($conn, $nombre, $apellido1, $apellido2, $email, $login, $pass);

            if ($registroExitoso) {
                $_SESSION['acceso_autorizado'] = true;
                header("Location: exito.php");
                cerrarConexion($conn);
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
    <link href="styles/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="snowflake">❅</div>
    <div class="snowflake">❅</div>
    <div class="snowflake">❅</div>
    <div class="snowflake">❅</div>
    <div class="snowflake">❅</div>
    <div class="snowflake">❅</div>
    <div class="snowflake">❅</div>
    <div class="snowflake">❅</div>
    <div class="snowflake">❅</div>
    <div class="snowflake">❅</div>

    <div class="container-page" id="Container">

        <div class="register-container">
            <h2>Formulario de registro</h2>

            <form action="index.php" method="post" id="registroForm">

                <div class="input-line-container">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" class="nombre-input-line" id="nombre" autocomplete="off" />
                    <p class="error">
                        <?php echo $nombreError; ?>
                    </p>
                </div>

                <div class="input-line-container">
                    <label for="apellido1">Primer apellido:</label>
                    <input type="text" name="apellido1" class="apellido1-input-line" id="apellido1"
                        autocomplete="off" />
                    <p class="error">
                        <?php echo $apellido1Error; ?>
                    </p>
                </div>

                <div class="input-line-container">
                    <label for="apellido2">Segundo apellido:</label>
                    <input type="text" name="apellido2" class="apellido2-input-line" id="apellido2"
                        autocomplete="off" />
                    <p class="error">
                        <?php echo $apellido2Error; ?>
                    </p>
                </div>

                <div class="input-line-container">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="email-input-line" id="email" autocomplete="off" />
                    <p class="error">
                        <?php echo $emailError; ?>
                    </p>
                </div>

                <div class="input-line-container">
                    <label for="login">Login:</label>
                    <input type="text" name="login" class="login-input-line" id="login" autocomplete="off" />
                    <p class="error">
                        <?php echo $loginError; ?>
                    </p>
                </div>

                <div class="input-line-container">
                    <label for="pass">Contraseña:</label>
                    <input type="password" name="pass" class="pass-input-line" id="pass" autocomplete="off" />
                    <p class="error">
                        <?php echo $passError; ?>
                    </p>
                </div>

                <input class="button-register" value="Registrarse" name="submit" type="submit" />

            </form>
        </div>
    </div>

    <script src="scripts/script.js"></script>

</body>

</html>