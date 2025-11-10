<?php

use IncludeDB\Conexion;

require_once("../../include/conex.php");
require_once("../../include/funciones.php");

$link = Conexion::conexion();
header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

if ($action == 'agregar') {
    $plato = $_POST['id_plato'];
    $tiempo = $_POST['tiempo_total'];
    $fuente = $_POST['fuente'];
    $tipo = $_POST['tipo_plato'];
    $precio = $_POST['precio'];

    $sql = "INSERT INTO recetas (id_plato, tiempo_total, fuente, tipo_plato, precio) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, 'isssd', $plato, $tiempo, $fuente, $tipo, $precio);
    $res = mysqli_stmt_execute($stmt);

    echo json_encode(['success' => $res]);

} elseif ($action == 'editar') {
    $id = $_POST['id_receta'];
    $plato = $_POST['id_plato'];
    $tiempo = $_POST['tiempo_total'];
    $fuente = $_POST['fuente'];
    $tipo = $_POST['tipo_plato'];
    $precio = $_POST['precio'];

    $sql = "UPDATE recetas SET id_plato=?, tiempo_total=?, fuente=?, tipo_plato=?, precio=? 
            WHERE id_receta=?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, 'isssdi', $plato, $tiempo, $fuente, $tipo, $precio, $id);
    $res = mysqli_stmt_execute($stmt);

    echo json_encode(['success' => $res]);

} elseif ($action == 'eliminar') {
    $id = $_POST['id'];
    $sql = "DELETE FROM recetas WHERE id_receta=?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $res = mysqli_stmt_execute($stmt);
    echo json_encode(['success' => $res]);

} else {
    echo json_encode(['success' => false, 'message' => 'Acción no válida']);
}
