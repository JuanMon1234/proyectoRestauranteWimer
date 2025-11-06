<?php
if (isset($_GET['R'])) {
    $mensaje = '';
    switch ($_GET['R']) {
        case '1': $mensaje = 'Correo enviado con instrucciones para recuperar tu contraseña.'; break;
        case '2': $mensaje = 'Correo no encontrado en el sistema.'; break;
        case '3': $mensaje = 'Error al enviar el correo. Intenta de nuevo.'; break;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h4>Recuperar contraseña</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($mensaje)): ?>
                            <div class="alert alert-info"><?= $mensaje ?></div>
                        <?php endif; ?>
                        <form method="GET" action="../controlador/recuperar_clave.php">
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" name="correo" id="correo" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Enviar instrucciones</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="login.php">Volver al login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
