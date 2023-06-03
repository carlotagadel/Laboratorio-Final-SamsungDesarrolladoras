<?php
session_start();

require_once 'config.php';
require_once 'functions.php';

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

    $nombreValido = validarNombre($nombre);
    $apellidoValido = validarApellidos($apellido1, $apellido2);
    $emailValido = validarEmail($email);
    $loginValido = validarLogin($login);
    $passValido = validarContraseña($pass);

    if (!$nombreValido) {
        $nombreError = "El nombre no debe contener números.";
    }
    if (!$apellidoValido) {
        $apellido1Error = "Los apellidos no deben contener números.";
        $apellido2Error = "Los apellidos no deben contener números.";
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
    <link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="login_form_container">
        <div class="login_form">
            <form action="index.php" method="post" id="registroForm">

                <h2>Formulario de registro</h2>

                <div class="input_group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" placeholder="Nombre" name="nombre" class="input_text" id="nombre"
                        autocomplete="off" />
                    <p class="error">
                        <?php echo $nombreError; ?>
                    </p>
                </div>

                <div class="input_group">
                    <label for="apellido1">Primer apellido:</label>
                    <input type="text" placeholder="Primer apellido" name="apellido1" class="input_text" id="apellido1"
                        autocomplete="off" />
                    <p class="error">
                        <?php echo $apellido1Error; ?>
                    </p>
                </div>

                <div class="input_group">
                    <label for="apellido2">Segundo apellido:</label>
                    <input type="text" placeholder="Segundo apellido" name="apellido2" class="input_text" id="apellido2"
                        autocomplete="off" />
                    <p class="error">
                        <?php echo $apellido2Error; ?>
                    </p>
                </div>

                <div class="input_group">
                    <label for="email">Email:</label>
                    <input type="email" placeholder="Email" name="email" class="input_text" id="email"
                        autocomplete="off" />
                    <p class="error">
                        <?php echo $emailError; ?>
                    </p>
                </div>

                <div class="input_group">
                    <label for="login">Login:</label>
                    <input type="text" placeholder="Login" name="login" class="input_text" id="login"
                        autocomplete="off" />
                    <p class="error">
                        <?php echo $loginError; ?>
                    </p>
                </div>

                <div class="input_group">
                    <label for="pass">Contraseña:</label>
                    <input type="password" placeholder="Contraseña" name="pass" class="input_text" id="pass"
                        autocomplete="off" />
                    <p class="error">
                        <?php echo $passError; ?>
                    </p>
                </div>
                
                <div class="button_group">
                    <input class="form-btn" name="submit" type="submit" value="Registrarse" />
                </div>
            </form>
        </div>
    </div>

    <script src="script.js"></script>

</body>

</html>