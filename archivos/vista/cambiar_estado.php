<?php
require_once("../../include/config.php");
require_once("../../include/funciones.php");

// Conexión a la base de datos
$conexion = conex(); // asegúrate de que retorna un mysqli válido

// Validar datos recibidos
if (empty($_POST['id']) || empty($_POST['estado'])) {
    echo json_encode(["status" => "error", "message" => "Faltan datos"]);
    exit;
}

$id = intval($_POST['id']);
$estado = trim($_POST['estado']);

// Validar estado permitido
$estados_permitidos = ['pendiente', 'activo', 'inactivo'];
if (!in_array($estado, $estados_permitidos)) {
    echo json_encode(["status" => "error", "message" => "Estado no válido"]);
    exit;
}

// Usar sentencia preparada
$stmt = $conexion->prepare("UPDATE usuarios SET estado = ? WHERE Idusuario = ?");
$stmt->bind_param("si", $estado, $id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Estado actualizado"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conexion->close();
?>
