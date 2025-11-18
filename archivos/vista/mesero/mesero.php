<?php

use IncludeDB\Conexion;

session_start();

// Redirigir si no hay sesión o si el rol no es mesero
if (!isset($_SESSION['Idrol']) || $_SESSION['Idrol'] != 3) {
    header("Location: index.php?k=4"); // Acceso no autorizado
    exit();
}

include_once ('../../include/conex.php') ;
$link = Conexion::conexion();

// Obtener datos del mesero desde la tabla usuarios
$id = intval($_SESSION['id']);
$query = "SELECT * FROM usuarios WHERE Idusuario = $id";
$result = mysqli_query($link, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $nombre = $row['Nombres'];
    $apellido = $row['Apellidos'];
} else {
    $nombre = "Mesero";
    $apellido = "";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Panel Mesero</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">Panel del Mesero</span>
    <span class="navbar-text text-white">
      Bienvenido, <?php echo $nombre . " " . $apellido; ?>
    </span>
    <a href="logout.php" class="btn btn-outline-light">Cerrar Sesión</a>
  </div>
</nav>

<div class="container mt-4">
  <div class="alert alert-info">
    <h4>Gestión de Pedidos</h4>
    <p>Aquí puedes visualizar y gestionar los pedidos de las mesas.</p>
  </div>
  <!-- Puedes agregar botones o funcionalidades específicas del mesero -->
</div>

</body>
</html>
