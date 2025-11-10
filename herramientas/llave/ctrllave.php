<?php

use IncludeDB\Conexion;

include '../../herramientas/llave/llave.php';
include '../../include/enviaremail.php';
include '../../include/config.php';

$link = Conexion::conexion();

$email_destinatario = $_POST['correoinicio'] ?? '';
$jTableResult = ['msjValidez' => '', 'rspst' => 0];

if (!filter_var($email_destinatario, FILTER_VALIDATE_EMAIL)) {
    $jTableResult['rspst'] = 0;
    $jTableResult['msjValidez'] = "Correo inválido";
    echo json_encode($jTableResult);
    exit;
}

// ✅ Verificar si el correo existe
$stmt = $link->prepare("SELECT Correo FROM usuarios WHERE Correo = ?");
$stmt->bind_param("s", $email_destinatario);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    $jTableResult['rspst'] = 2;
    $jTableResult['msjValidez'] = "El correo no está registrado";
    echo json_encode($jTableResult);
    exit;
}

// ✅ Generar clave segura de 12 caracteres
$clave = bin2hex(random_bytes(6)); // 12 caracteres

// ✅ Enviar correo
$resul = enviarCorreo($email_remitente, $email_destinatario, $password, $clave);

if ($resul !== true) {
    $jTableResult['rspst'] = 3;
    $jTableResult['msjValidez'] = "No se pudo enviar el correo";
    echo json_encode($jTableResult);
    exit;
}

// ✅ Encriptar contraseña
$clave_encriptada = password_hash($clave, PASSWORD_DEFAULT);

// ✅ Actualizar clave cifrada
$stmt2 = $link->prepare("UPDATE usuarios SET Clave = ? WHERE Correo = ?");
$stmt2->bind_param("ss", $clave_encriptada, $email_destinatario);

if ($stmt2->execute()) {
    $jTableResult['rspst'] = 1;
    $jTableResult['msjValidez'] = "Se envió un correo con su nueva clave";
} else {
    $jTableResult['rspst'] = 4;
    $jTableResult['msjValidez'] = "Error al actualizar la contraseña";
}

echo json_encode($jTableResult);
exit;

