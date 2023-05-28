<!DOCTYPE html>
<html>
<head>
  <title>Éxito</title>

  <script>
    function mostrarDatos() {
      var tabla = document.getElementById("tablaDatos");
      tabla.style.display = "block";
    }
    
  </script>

  <style>
    #tablaDatos {
      display: none;
    }
  </style>
</head>

<body>
  <h1>Registro exitoso</h1>
  <p>¡Se ha registrado correctamente!</p>

  <?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "cursosql";

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $apellido1 = isset($_POST['apellido1']) ? $_POST['apellido1'] : '';
    $apellido2 = isset($_POST['apellido2']) ? $_POST['apellido2'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $login = isset($_POST['login']) ? $_POST['login'] : '';
    $pass = isset($_POST['pass']) ? $_POST['pass'] : '';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      die("Error en la conexión a la base de datos: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM usuarios_formulario";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo "<h2>Datos registrados</h2>";
      echo "<button onclick=\"mostrarDatos()\">Mostrar datos</button>";
      echo "<table id=\"tablaDatos\">";
      echo "<tr><th>Nombre</th><th>Apellido1</th><th>Apellido2</th><th>Email</th><th>Login</th><th>Contraseña</th></tr>";

      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["nombre"] . "</td>";
        echo "<td>" . $row["apellido1"] . "</td>";
        echo "<td>" . $row["apellido2"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["login"] . "</td>";
        echo "<td>" . $row["pass"] . "</td>";
        echo "</tr>";
      }
      echo "</table>";

    } else {

      echo "No se encontraron datos registrados.";

    }

    $conn->close();
  }

  ?>

  <br>
  <a href="index.html">Volver al formulario</a>

</body>
</html>