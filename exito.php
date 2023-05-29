<!DOCTYPE html>
<html>

<head>
  <title>Éxito</title>
  <link href="exito_style.css" rel="stylesheet" type="text/css">
</head>

<body>
  <h1>Registro exitoso</h1>
  <p>¡Se ha registrado correctamente!</p>

  <button onclick="mostrarTabla()">Mostrar tabla</button>

  <?php

  require_once 'functions.php';

  $conn = conectarDB();

  $sql = "SELECT * FROM usuarios_formulario";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo "<h2>Datos registrados</h2>";
    echo "<table id='tabla'>";
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

  cerrarConexion($conn);
  
  ?>

  <br>

  <a href="index.php">Volver al formulario</a>

  <script src="exito_script.js"></script>
</body>

</html>