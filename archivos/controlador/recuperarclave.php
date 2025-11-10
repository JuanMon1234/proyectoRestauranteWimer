<?php
include_once("../../include/conex.php");
require_once '../../herramientas/PHPMailer/src/PHPMailer.php';
require_once '../../herramientas/PHPMailer/src/SMTP.php';
require_once '../../herramientas/PHPMailer/src/Exception.php';

use IncludeDB\Conexion;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$env = include('../../include/env.php');
header('Content-Type: application/json');

$link = Conexion::conexion();
$correo = htmlspecialchars(trim($_GET['correo'] ?? ''));

if (empty($correo)) {
    echo json_encode(['success' => false, 'msg' => 'Debes ingresar un correo.']);
    exit;
}

// Verificar si el correo existe
$consulta = "SELECT * FROM usuarios WHERE Correo = ?";
$stmt = mysqli_prepare($link, $consulta);
mysqli_stmt_bind_param($stmt, "s", $correo);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($usuario = mysqli_fetch_assoc($result)) {

    $token = bin2hex(random_bytes(32));

    // Guardar token
    $sql_token = "UPDATE usuarios SET Token_recuperacion = ? WHERE Correo = ?";
    $stmt2 = mysqli_prepare($link, $sql_token);
    mysqli_stmt_bind_param($stmt2, "ss", $token, $correo);
    mysqli_stmt_execute($stmt2);

    // Enviar correo
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $env['MAIL_USER'];
        $mail->Password = $env['MAIL_PASS'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        // Datos del mensaje
        $mail->setFrom('fernandomontilla8@gmail.com', 'Soporte Restaurante');
        $mail->addAddress($correo, $usuario['Nombres']);
        $mail->isHTML(true);
        $mail->Subject = 'Recuperación de contraseña';

        $mail->Body = "
            Hola <strong>{$usuario['Nombres']}</strong>,<br><br>
            Haz clic en el siguiente enlace para restablecer tu contraseña:<br>
            <a href='http://localhost/pruebaWilmer/archivos/vista/nuevaclave.php?token=$token'>Recuperar contraseña</a><br><br>
            Si no solicitaste este cambio, puedes ignorar este mensaje.<br><br>
            Atentamente,<br>Soporte del Restaurante.
        ";

        $mail->send();

        echo json_encode([
            'success' => true,
            'msg' => 'Correo enviado con éxito. Revisa tu bandeja de entrada.'
        ]);

    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'msg' => 'Error al enviar correo: ' . $mail->ErrorInfo
        ]);
    }

} else {
    echo json_encode([
        'success' => false,
        'msg'     => 'El correo no está registrado.'
    ]);
}
