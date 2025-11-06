<?php
include("../../include/conex.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_SESSION["id_usuario"]; // Asegúrate de tener esto en sesión
    $id_mesa = $_POST["id_mesa"];
    $fecha = $_POST["fecha"];
    $hora_inicio = $_POST["hora_inicio"];
    $hora_fin = $_POST["hora_fin"];

    $sql = "INSERT INTO reservas (id_usuario, id_mesa, fecha_reserva, hora_inicio, hora_fin)
            VALUES ('$id_usuario', '$id_mesa', '$fecha', '$hora_inicio', '$hora_fin')";
    
    if (mysqli_query($conex, $sql)) {
        echo "✅ Reserva realizada correctamente.";
    } else {
        echo "❌ Error al hacer la reserva: " . mysqli_error($conex);
    }
}
?>
