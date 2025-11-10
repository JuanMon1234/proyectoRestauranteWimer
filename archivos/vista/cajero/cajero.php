<?php

use IncludeDB\Conexion;

include('../../include/conex.php');
$link=Conexion::conexion();

session_start();

// Protección por rol
if (!isset($_SESSION['Idrol']) || $_SESSION['Idrol'] != 4) {
    header("Location: index.php?k=3");
    exit();
}
$id=$_SESSION['id'];
$rol=$_SESSION['Idrol'];


include('archivos\vista\quien.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Cajero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Bienvenido, Cajero</h2>
    <ul class="list-group">
        <li class="list-group-item"><a href="generar_factura.php">Generar Factura</a></li>
        <li class="list-group-item"><a href="ver_pedidos.php">Ver Pedidos</a></li>
        <li class="list-group-item"><a href="cerrarsesion.php">Cerrar sesión</a></li>
    </ul>
</div>
</body>
</html>
