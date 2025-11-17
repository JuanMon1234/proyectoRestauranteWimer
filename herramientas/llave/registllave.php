<?php

use IncludeDB\Conexion;

include '../../herramientas/llave/llave.php';
include '../../include/registroenviar.php';
include '../../include/config.php';

$link = Conexion::conexion();

$jTableResult = array();

// --- Función para evitar LOG INJECTION ---
function limpiarEntrada($str) {
    // Eliminar saltos de línea → previene inyección de registros
    $str = str_replace(array("\n", "\r"), '', $str);

    // Eliminar caracteres de control ASCII
    $str = preg_replace('/[\x00-\x1F\x7F]/', '', $str);

    // Trim final
    return trim($str);
}

if (isset($_POST['correo'])) {

    // --- Entrada controlada y purificada ---
    $email_destinatario = limpiarEntrada($_POST['correo']);

    // Validar correo real
    if (!filter_var($email_destinatario, FILTER_VALIDATE_EMAIL)) {
        $jTableResult['rspst'] = 4;
        $jTableResult['msjValidez'] = "Correo inválido o manipulado";
        echo json_encode($jTableResult);
        exit();
    }

    // --- Acción interna que no depende del usuario ---
    $resul = enviarCorreo($email_remitente, $email_destinatario, $password);

    if ($resul === true) {
        $jTableResult['rspst'] = 1;
        $jTableResult['msjValidez'] = "Se envió el correo correctamente";
    } else {
        $jTableResult['rspst'] = 3;
        $jTableResult['msjValidez'] = "No se pudo enviar el correo";
    }

} else {
    $jTableResult['rspst'] = 2;
    $jTableResult['msjValidez'] = "No se recibió un correo para el registro";
}

echo json_encode($jTableResult);
