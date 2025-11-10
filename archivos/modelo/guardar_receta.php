<?php

use IncludeDB\Conexion;

session_start();
include('../../include/conex.php');
$link = Conexion::conexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = mysqli_real_escape_string($link, $_POST['nombre']);
    $tipo = mysqli_real_escape_string($link, $_POST['tipo_plato']);
    $ingrediente = mysqli_real_escape_string($link, $_POST['ingrediente_principal']);
    $precio = floatval($_POST['precio']);
    $comentario = mysqli_real_escape_string($link, $_POST['comentario']);
    $fuente = mysqli_real_escape_string($link, $_POST['fuente']);
    $ubicacion = mysqli_real_escape_string($link, $_POST['ubicacion']);
    $tiempo_total = intval($_POST['tiempo_total']);

    // 1. Insertar el nombre del plato en la tabla 'platos'
    $sql_plato = "INSERT INTO platos (nombre) VALUES ('$nombre')";
    if (mysqli_query($link, $sql_plato)) {
        $id_plato = mysqli_insert_id($link);

        // 2. Insertar en la tabla 'recetas'
        $sql_receta = "INSERT INTO recetas (
            id_plato, tiempo_total, fuente, ubicacion_fisica, tipo_plato, 
            ingrediente_principal, precio, comentario_personal
        ) VALUES (
            '$id_plato', '$tiempo_total', '$fuente', '$ubicacion', '$tipo', 
            '$ingrediente', '$precio', '$comentario'
        )";

        if (mysqli_query($link, $sql_receta)) {
            header("Location: chef.php?success=1");
            exit();
        } else {
            echo "Error al guardar la receta: " . mysqli_error($link);
        }
    } else {
        echo "Error al guardar el plato: " . mysqli_error($link);
    }
} else {
    header("Location: agregar_receta.php");
    exit();
}
?>
