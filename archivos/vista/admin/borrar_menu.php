<?php
include('../../include/conex.php');
$conexion = conex();

$id = $_GET['id'];
mysqli_query($conexion, "DELETE FROM menus WHERE id_menu = $id");

header('Location: archivos\vista\menus.php');
exit();
?>
