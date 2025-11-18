<?php
include_once("../../include/conex.php");
require_once "../../include/autoload.php";
require_once '../../herramientas/PHPMailer/src/PHPMailer.php';
require_once '../../herramientas/PHPMailer/src/SMTP.php';
require_once '../../herramientas/PHPMailer/src/Exception.php';

use IncludeDB\Conexion;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$env = include_once "../../include/env.php";
header('Content-Type: application/json');

$link = Conexion::conexion();

/**
 * 🔐 Función para impedir LOG INJECTION y sanitizar entrada
 */
function limpiarEntrada($data) {
    // Eliminar saltos de línea → PREVIENE creación de nuevas entradas en logs
    $data = str_replace(["\r", "\n"], "", $data);

    // Quitar caracteres de control ASCII
    $data = preg_replace('/[\x00-\x1F\x7F]/', '', $data);

    return trim($data);
}

// ---- Se limpia lo que viene del usuario ----
$correo = limpiarEntrada($_GET['correo'] ?? "");

// Validación estricta
if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'msg'     => 'Debes ingresar un correo válido.'
    ]);
    exit;
}

// --- Consulta segura: NUNCA se registra lo que el usuario envía ---
$consulta = "SELECT * FROM usuarios WHERE Correo = ?";
$stmt = mysqli_prepare($link, $consulta);
mysqli_stmt_bind_param($stmt, "s", $correo);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($usuario = mysqli_fetch_assoc($result)) {

    // Token generado internamente (NO depende del usuario)
    $token = bin2hex(random_bytes(32));

    // Guardar token sanitizado
    $sql_token = "UPDATE usuarios SET Token_recuperacion = ? WHERE Correo = ?";
    $stmt2 = mysqli_prepare($link, $sql_token);
    mysqli_stmt_bind_param($stmt2, "ss", $token, $correo);
    mysqli_stmt_execute($stmt2);

    // Configurar PHPMailer
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
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            ]
        ];

        // Datos del mensaje
        $mail->setFrom('fernandomontilla8@gmail.com', 'Soporte Restaurante');

        // ❗ Nombre del usuario NO se usa directamente (evita manipulación de registros del servidor SMTP)
        $nombreSeguro = limpiarEntrada($usuario['Nombres']);
        $mail->addAddress($correo, $nombreSeguro);

        $mail->isHTML(true);
        $mail->Subject = 'Recuperación de contraseña';

        // Se limpian valores antes de insertarlos en el HTML
        $bodyNombre = htmlspecialchars($nombreSeguro, ENT_QUOTES, 'UTF-8');

        $mail->Body = "
            Hola <strong>{$bodyNombre}</strong>,<br><br>
            Haz clic en el siguiente enlace para restablecer tu contraseña:<br>
            <a href='http://localhost/pruebaWilmer/archivos/vista/nuevaclave.php?token={$token}'>
                Recuperar contraseña
            </a><br><br>
            Si no solicitaste este cambio, puedes ignorar este mensaje.<br><br>
            Atentamente,<br>Soporte del Restaurante.
        ";

        $mail->send();

        echo json_encode([
            'success' => true,
            'msg' => 'Correo enviado con éxito. Revisa tu bandeja de entrada.'
        ]);

    } catch (Exception $e) {
        // Error seguro: NO se imprime contenido enviado por el usuario
        echo json_encode([
            'success' => false,
            'msg' => 'Error al enviar correo.'
        ]);
    }

} else {
    echo json_encode([
        'success' => false,
        'msg'     => 'El correo no está registrado.'
    ]);
}
