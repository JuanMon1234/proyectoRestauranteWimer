<?php
require_once(__DIR__ . "/../../include/config.php");
require_once(__DIR__ . "/../../include/funciones.php");
require_once(__DIR__ . "/../../herramientas/llave/llave.php"); // si necesitas llaves

// --- PHPMailer --- (si vas a enviar correo)
require '../../herramientas/PHPMailermas/src/Exception.php';
require '../../herramientas/PHPMailermas/src/PHPMailer.php';
require '../../herramientas/PHPMailermas/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// --- Función para enviar correo ---
function enviarCorreo($email_remitente, $email_destinatario, $password) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $email_remitente;
        $mail->Password = $password;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($email_remitente, 'Sabor de Hogar');
        $mail->addAddress($email_destinatario);

        $mail->isHTML(true);
        $mail->Subject = 'Registro en la base de datos Sabor de Hogar';
        $mail->Body = "
        <p>Hola, tu usuario ha sido creado en Sabor de Hogar.</p>
        <p>Correo: <b>$email_destinatario</b></p>
        <p>Contraseña: <b>$password</b></p>
        <p>Por seguridad, cambia tu contraseña al ingresar por primera vez.</p>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Error al enviar correo: {$mail->ErrorInfo}");
        return false;
    }
}

// Configuración remitente
$email_remitente = 'tucorreo@gmail.com';
$password_app    = 'tu_password_app';

// --- POST ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres        = trim($_POST['nombres']);
    $apellidos      = trim($_POST['apellidos']);
    $correo         = trim($_POST['correo']);
    $identificacion = trim($_POST['identificacion']);
    $celular        = trim($_POST['celular']);
    $rol            = intval($_POST['idrol']);
    $tipodoc        = intval($_POST['idtipodoc']);
    $estado         = 'pendiente';

    // Bloquear rol administrador
    if ($rol == 1) {
        echo "<div class='alert alert-danger'>⚠️ No se puede asignar el rol de administrador.</div>";
        exit;
    }

    // Verificar duplicados
    $check = ejecutarConsulta("SELECT COUNT(*) as total FROM usuarios 
                            WHERE Correo = '$correo' OR Identificacion = '$identificacion'");
    $row = mysqli_fetch_assoc($check);
    if ($row['total'] > 0) {
        echo "<div class='alert alert-warning'>⚠️ Ya existe un usuario con ese correo o identificación.</div>";
        exit;
    }

    // Generar contraseña aleatoria y hashearla
    $clave = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);
    $claveHash = password_hash($clave, PASSWORD_DEFAULT);

    // Insertar usuario
    $sql = "INSERT INTO usuarios 
            (Nombres, Apellidos, Correo, Identificacion, Celular, idrol, Idtipodoc, estado, Clave)
            VALUES 
            ('$nombres', '$apellidos', '$correo', '$identificacion', '$celular', $rol, $tipodoc, '$estado', '$claveHash')";
    $res = ejecutarConsulta($sql);

    if ($res) {
        // Enviar correo al usuario con la contraseña generada
        enviarCorreo($email_remitente, $correo, $clave);
        echo "<div class='alert alert-success'>Usuario agregado correctamente.</div>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>❌ Error al agregar usuario</div>";
        exit;
    }
}
?>

<!-- Formulario parcial -->
<form id="formAgregarUsuario">
    <div class="mb-3">
        <label>Nombres</label>
        <input type="text" name="nombres" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Apellidos</label>
        <input type="text" name="apellidos" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Correo</label>
        <input type="email" name="correo" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Identificación</label>
        <input type="text" name="identificacion" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Celular</label>
        <input type="text" name="celular" class="form-control">
    </div>
    <div class="mb-3">
        <label>Tipo de documento</label>
        <select name="idtipodoc" class="form-select" required>
            <?php
            $docs = ejecutarConsulta("SELECT Idtipodoc, TipoDoc FROM tipodoc");
            while ($d = mysqli_fetch_assoc($docs)) {
                echo "<option value='{$d['Idtipodoc']}'>{$d['TipoDoc']}</option>";
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Rol</label>
        <select name="idrol" class="form-select" required>
            <?php
            $roles = ejecutarConsulta("SELECT idrol, Nombre FROM roles");
            while($r = mysqli_fetch_assoc($roles)){
                if ($r['idrol'] == 1) continue;
                echo "<option value='{$r['idrol']}'>{$r['Nombre']}</option>";
            }
            ?>
        </select>
    </div>
    <div class="text-end">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    </div>
</form>
