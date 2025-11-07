<?php
session_start();
if (!isset($_SESSION['Idrol']) || $_SESSION['Idrol'] != 2) {
    header("Location: index.php?k=4");
    exit();
}
use IncludeDB\conexion;

$conexion = conexion::conectar();

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID no válido.");
}

$id = (int)$_GET['id'];

$stmt = mysqli_prepare($conexion, "DELETE FROM menus WHERE id_menu = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);
mysqli_close($conexion);

header('Location: ../../archivos/vista/menus.php');
exit();
?>
