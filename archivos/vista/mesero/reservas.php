<?php
include "../../include/conex.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_SESSION["id_usuario"])) {
        echo "❌ No tienes una sesión activa.";
        exit;
    }

    $id_usuario = intval($_SESSION["id_usuario"]);
    $id_mesa = intval($_POST["id_mesa"]);
    $fecha = $_POST["fecha"] ?? '';
    $hora_inicio = $_POST["hora_inicio"] ?? '';
    $hora_fin = $_POST["hora_fin"] ?? '';

    // Validaciones básicas
    if (!$id_mesa || !$fecha || !$hora_inicio || !$hora_fin) {
        echo "❌ Faltan datos obligatorios.";
        exit;
    }

    // Consulta preparada
    $sql = "INSERT INTO reservas (id_usuario, id_mesa, fecha_reserva, hora_inicio, hora_fin)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conex->prepare($sql);

    if (!$stmt) {
        echo "❌ Error preparando consulta: " . $conex->error;
        exit;
    }

    $stmt->bind_param("iisss", $id_usuario, $id_mesa, $fecha, $hora_inicio, $hora_fin);

    if ($stmt->execute()) {
        echo "✅ Reserva realizada correctamente.";
    } else {
        echo "❌ Error al hacer la reserva: " . $stmt->error;
    }

    $stmt->close();
}
?>
