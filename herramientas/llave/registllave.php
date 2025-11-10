<?php

use IncludeDB\Conexion;

include '../../herramientas/llave/llave.php';
include '../../include/registroenviar.php';
include '../../include/config.php'; // Aquí tienes el remitente y la contraseña de app
$link = Conexion::conexion();

if(isset($_POST['correo'])) {

    $email_destinatario = $_POST['correo'];

    $jTableResult = array();


        // ✅ Enviar el correo
        $resul = enviarCorreo($email_remitente, $email_destinatario, $password);

        if ($resul == true) {
            
                $jTableResult['rspst'] = 1;
                $jTableResult['msjValidez'] = "Se registró exitosamente en la base de datos sabor de hogar";
        } else {
            $jTableResult['rspst'] = 3;
            $jTableResult['msjValidez'] = "No se pudo enviar el correo ";
        }

    } else {
        $jTableResult['rspst'] = 2;
        $jTableResult['msjValidez'] = "No se ha recibido un correo para el registro";
    }
