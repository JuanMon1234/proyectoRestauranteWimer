<?php

use IncludeDB\Conexion;

session_start();
if (!isset($_SESSION['Idrol']) || $_SESSION['Idrol'] != 2) {
    header("Location: index.php?k=4");
    exit();
}
include '../../include/conex.php';
$conexion = Conexion::conexion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $calorias = $_POST['calorias'];

    $query = "INSERT INTO ingredientes (nombre, calorias) VALUES (?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("si", $nombre, $calorias);
    
    if ($stmt->execute()) {
        header("Location: archivos\vista\ingredientes.php");
        exit();
    } else {
        echo "Error al guardar ingrediente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Ingrediente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2>➕ Nuevo Ingrediente</h2>
    <form method="POST" action="agregar_ingrediente.php">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Ingrediente</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>

        <div class="mb-3">
            <label for="calorias" class="form-label">Calorías</label>
            <input type="number" class="form-control" id="calorias" name="calorias" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="ingredientes.php" class="btn btn-secondary">Volver</a>
    </form>
</div>

</body>
</html>
