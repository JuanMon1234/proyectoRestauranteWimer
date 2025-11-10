<?php

use IncludeDB\Conexion;

include '../../herramientas/llave/llave.php';
include '../../include/enviaremail.php';
include '../../include/config.php'; // Aquí tienes el remitente y la contraseña de app
$link = Conexion::conexion();

$email_destinatario = $_POST['correoinicio'] ?? '';
$jTableResult = ['msjValidez' => '', 'rspst' => 0];

if (filter_var($email_destinatario, FILTER_VALIDATE_EMAIL)) {

    $sql = "SELECT Correo FROM usuarios WHERE Correo = '$email_destinatario'";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {

        // ✅ Generar clave aleatoria
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $clave = '';
        for ($i = 0; $i < 8; $i++) {
            $clave .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        // ✅ Enviar el correo
        $resul = enviarCorreo($email_remitente, $email_destinatario, $password, $clave);

        if ($resul == true) {
            // ✅ Encriptar la nueva clave y actualizar en BD
                $clave_encriptada = password_hash($clave, PASSWORD_DEFAULT);
                $update = "UPDATE usuarios SET Clave = '$clave_encriptada' WHERE Correo = '$email_destinatario'";
                $actualizado = mysqli_query($link, $update);

                if ($actualizado) {
                $jTableResult['rspst'] = 1;
                $jTableResult['msjValidez'] = "Se envió un correo con su nueva clave";
                $sqlclave = "UPDATE usuarios SET Clave = '$clave' WHERE usuarios.Correo = '$email_destinatario'";
                $resultclave = mysqli_query($link, $sqlclave);

            // } else {
            //     $jTableResult['rspst'] = 4;
            //     $jTableResult['msjValidez'] = "Error al actualizar la contraseña en la base de datos";
            // }
        } else {
            $jTableResult['rspst'] = 3;
            $jTableResult['msjValidez'] = "No se pudo enviar el correo de recuperación";
        }

    } else {
        $jTableResult['rspst'] = 2;
        $jTableResult['msjValidez'] = "El correo no está registrado";
    }

} else {
    $jTableResult['rspst'] = 0;
    $jTableResult['msjValidez'] = "Correo inválido";
}

header('Content-Type: application/json');
echo json_encode($jTableResult);
exit;
}