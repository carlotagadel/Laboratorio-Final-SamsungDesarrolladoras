<?php
function conectarDB() {
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function cerrarConexion($conn) {
    $conn->close();
}

function validarNombre($nombre) {
    return preg_match('/^[A-Za-z]+$/', $nombre);
}

function validarApellidos($apellido1, $apellido2) {
    return preg_match('/^[A-Za-záéíóúÁÉÍÓÚüÜ]+$/', $apellido1) && preg_match('/^[A-Za-záéíóúÁÉÍÓÚüÜ]+$/', $apellido2);
}

function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validarContraseña($pass) {
    return (strlen($pass) >= 4 && strlen($pass) <= 8);
}

function verificarEmailExistente($conn, $email) {
    $sqlVerificar = "SELECT * FROM usuarios_formulario WHERE email='$email'";
    $result = $conn->query($sqlVerificar);

    if ($result->num_rows > 0) {
        return true;
    }

    return false;
}

function insertarUsuario($conn, $nombre, $apellido1, $apellido2, $email, $login, $pass) {
    $sqlInsertar = "INSERT INTO usuarios_formulario (NOMBRE, PRIMER_APELLIDO, SEGUNDO_APELLIDO, EMAIL, LOG_IN, CONTRASEÑA) VALUES ('$nombre', '$apellido1', '$apellido2', '$email', '$login', '$pass')";

    return $conn->query($sqlInsertar);

}
?>