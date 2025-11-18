<?php

use IncludeDB\Conexion;

include_once "../../include/conex.php" ;
$link = Conexion::conexion();

$mensaje = "";
$token = htmlspecialchars($_GET['token'] ?? '');

if (empty($token)) {
    echo "Token no válido.";
    exit;
}

// Validar token
$sql = "SELECT * FROM usuarios WHERE Token_recuperacion = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "s", $token);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) == 0) {
    $mensaje = "Este enlace de recuperación ha expirado o ya fue utilizado.";
} else {
    $usuario = mysqli_fetch_assoc($resultado);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nueva_clave = $_POST['nueva_clave'] ?? '';
    $confirmar_clave = $_POST['confirmar_clave'] ?? '';

    if (empty($nueva_clave) || empty($confirmar_clave)) {
        $mensaje = "Por favor completa ambos campos.";
    } elseif (strlen($nueva_clave) < 6) {
        $mensaje = "La contraseña debe tener al menos 6 caracteres.";
    } elseif ($nueva_clave !== $confirmar_clave) {
        $mensaje = "Las contraseñas no coinciden.";
    } else {
        $clave_hash = password_hash($nueva_clave, PASSWORD_DEFAULT);

        $update = "UPDATE usuarios SET Clave = ?, Token_recuperacion = NULL WHERE Token_recuperacion = ?";
        $stmt2 = mysqli_prepare($link, $update);
        mysqli_stmt_bind_param($stmt2, "ss", $clave_hash, $token);

        if (mysqli_stmt_execute($stmt2)) {
            header("Location: login.php?R=4");
            exit;
        } else {
            $mensaje = "Error al actualizar la contraseña.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Restablecer Contraseña</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($mensaje)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($mensaje) ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="nueva_clave" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" name="nueva_clave" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmar_clave" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" name="confirmar_clave" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Guardar Nueva Contraseña</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
