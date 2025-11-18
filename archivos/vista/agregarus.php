<?php
require_once __DIR__ . "/../../include/config.php";
require_once __DIR__ . "/../../include/funciones.php";
require_once __DIR__ . "/../../herramientas/llave/llave.php";

require '../../herramientas/PHPMailermas/src/Exception.php';
require '../../herramientas/PHPMailermas/src/PHPMailer.php';
require '../../herramientas/PHPMailermas/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// --- Cargar credenciales desde archivo config ---
$email_remitente = 'tucorreo@gmail.com';
$password_app = 'tu_password_app';

// --- Función segura para enviar correo ---
function enviarCorreo($email_remitente, $email_destinatario, $password_app, $clave_usuario) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $email_remitente;
        $mail->Password   = $password_app;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom($email_remitente, 'Sabor de Hogar');
        $mail->addAddress($email_destinatario);

        $mail->isHTML(true);
        $mail->Subject = 'Registro en la base de datos Sabor de Hogar';
        $mail->Body = "
            <p>Hola, tu usuario ha sido creado en Sabor de Hogar.</p>
            <p><b>Correo:</b> $email_destinatario</p>
            <p><b>Contraseña:</b> $clave_usuario</p>
            <p>Por seguridad, cambia tu contraseña al ingresar.</p>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Error al enviar correo: {$mail->ErrorInfo}");
        return false;
    }
}

// --- PROCESAR POST ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $conex;

    // Sanitización
    $nombres        = mysqli_real_escape_string($conex, $_POST['nombres']);
    $apellidos      = mysqli_real_escape_string($conex, $_POST['apellidos']);
    $correo         = mysqli_real_escape_string($conex, $_POST['correo']);
    $identificacion = mysqli_real_escape_string($conex, $_POST['identificacion']);
    $celular        = mysqli_real_escape_string($conex, $_POST['celular']);
    $rol            = intval($_POST['idrol']);
    $tipodoc        = intval($_POST['idtipodoc']);
    $estado         = 'pendiente';

    if ($rol == 1) {
        echo "<div class='alert alert-danger'>⚠️ No se puede asignar el rol de administrador.</div>";
        exit;
    }

    // CONSULTA SEGURA PARA VERIFICAR DUPLICADOS
    $stmt = mysqli_prepare($conex,
        "SELECT COUNT(*) FROM usuarios WHERE Correo = ? OR Identificacion = ?"
    );
    mysqli_stmt_bind_param($stmt, "ss", $correo, $identificacion);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $total);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($total > 0) {
        echo "<div class='alert alert-warning'>⚠️ Ya existe un usuario con ese correo o identificación.</div>";
        exit;
    }

    // GENERAR CONTRASEÑA
    $clave = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);
    $claveHash = password_hash($clave, PASSWORD_DEFAULT);

    // CONSULTA PREPARADA PARA INSERTAR
    $stmt = mysqli_prepare($conex, "INSERT INTO usuarios (Nombres, Apellidos, Correo, Identificacion, Celular, idrol, Idtipodoc, estado, Clave) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmt, "sssssiiss", $nombres, $apellidos, $correo, $identificacion, $celular, $rol, $tipodoc, $estado, $claveHash
    );
    if (mysqli_stmt_execute($stmt)) {
        enviarCorreo($email_remitente, $correo, $password_app, $clave);
        echo "<div class='alert alert-success'>✅ Usuario agregado correctamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>❌ Error al agregar usuario</div>";
    }

    mysqli_stmt_close($stmt);
}
