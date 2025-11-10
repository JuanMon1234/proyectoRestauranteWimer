<?php

use IncludeDB\Conexion;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once('../include/conex.php');
$link = Conexion::conexion();

// Validar sesión
if (!isset($_SESSION['idrol']) || !isset($_SESSION['id'])) {
    header("Location: index.php?k=3");
    exit();
}

$rol = $_SESSION['idrol'];
$id = intval($_SESSION['id']); // Prevención básica de inyecciones

// Asumiendo que todos los usuarios están en la tabla usuarios
$sql = "SELECT * FROM usuarios WHERE Idusuario = $id";
$result = mysqli_query($link, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    $nombre = $row['Nombres'];
    $apellido = $row['Apellidos'];

    // Asignar nombre del rol para mostrar (puedes ajustar los nombres)
    switch ($rol) {
        case 1:
            $nrol = "Administrador";
            break;
        case 2:
            $nrol = "Chef";
            break;
        case 3:
            $nrol = "Mesero";
            break;
        case 4:
            $nrol = "Cajero";
            break;
        case 5:
            $nrol = "Cliente";
            break;
        default:
            $nrol = "Desconocido";
            break;
    }
} else {
    // Si no encontró al usuario en la BD
    $nombre = "Desconocido";
    $apellido = "";
    $nrol = "Desconocido";
}
?>
