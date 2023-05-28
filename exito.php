<!DOCTYPE html>
<html>
<head>
  <title>Éxito</title>
</head>

<body>
  <h1>Registro exitoso</h1>
  <p>¡Se ha registrado correctamente!</p>

  <?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "cursosql";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM usuarios_formulario";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo "<h2>Datos registrados</h2>";
    echo "<table>";
    echo "<tr><th>Nombre</th><th>Apellido1</th><th>Apellido2</th><th>Email</th><th>Login</th><th>Contraseña</th></tr>";

    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $row["NOMBRE"] . "</td>";
      echo "<td>" . $row["PRIMER_APELLIDO"] . "</td>";
      echo "<td>" . $row["SEGUNDO_APELLIDO"] . "</td>";
      echo "<td>" . $row["EMAIL"] . "</td>";
      echo "<td>" . $row["LOG_IN"] . "</td>";
      echo "<td>" . $row["CONTRASEÑA"] . "</td>";
      echo "</tr>";
    }
    echo "</table>";

  } else {
    echo "<p>No se encontraron datos registrados.</p>";
  }

  $conn->close();
  ?>

  <br>
  
  <a href="index.php">Volver al formulario</a>

</body>
</html>