<?php

$servername = "localhost";
$username = "root";
$password = '';
$dbname = "cursosql";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
        $apellido1 = isset($_POST['apellido1']) ? $_POST['apellido1'] : '';
        $apellido2 = isset($_POST['apellido2']) ? $_POST['apellido2'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $login = isset($_POST['login']) ? $_POST['login'] : '';
        $pass = isset($_POST['pass']) ? $_POST['pass'] : '';

    if (empty($nombre) || empty($apellido1) || empty($apellido2) || empty($email) || empty($login) || empty($pass)) {
        echo "Por favor, complete todos los campos del formulario.";
            header("Location: index.html");
            exit;

    } else {

        $nombreValido = preg_match('/^[A-Za-z]+$/', $nombre);
        $apellido1Valido = preg_match('/^[A-Za-z]+$/', $apellido1);
        $apellido2Valido = preg_match('/^[A-Za-z]+$/', $apellido2);
        $emailValido = filter_var($email, FILTER_VALIDATE_EMAIL);
        $passValido = (strlen($pass) >= 4 && strlen($pass) <= 8);
    
        if (!$nombreValido || !$apellido1Valido || !$apellido2Valido) {

          echo "Los campos de nombre y apellidos no deben contener números.";
            header("Location: index.html");
            exit;

        } elseif (!$emailValido) {

          echo "El email ingresado no es válido.";
            header("Location: index.html");
            exit;

        } elseif (!$passValido) {

          echo "La contraseña debe tener entre 4 y 8 caracteres.";
            header("Location: index.html");
            exit;

        } else {

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
            }

            $emailExiste = false;
            $sqlVerificar = "SELECT * FROM usuarios_formulario WHERE email='$email'";
            $result = $conn->query($sqlVerificar);

        if ($result->num_rows > 0) {
            $emailExiste = true;
            echo "El email ingresado ya está registrado.";
            header("Location: index.html");
            exit;

        } else {

            $sqlInsertar = "INSERT INTO usuarios_formulario (NOMBRE, PRIMER_APELLIDO, SEGUNDO_APELLIDO, EMAIL, LOG_IN, CONTRASEÑA) VALUES ('$nombre', '$apellido1', '$apellido2', '$email', '$login', '$pass')";
           
            if ($conn->query($sqlInsertar) === TRUE) {
                header("Location: exito.php");
                exit;

            } else {
               echo "Error al registrar los datos en la base de datos: " . $conn->error;
               header("Location: index.html");
               exit;
        }
      }

        $conn->close();

        }
    }
}

?>