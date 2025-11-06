<?php
include('../../include/conex.php');
$link=conex();

session_start();

// Protección por rol
if (!isset($_SESSION['Idrol']) || $_SESSION['Idrol'] != 5) {
    header("Location: index.php?k=3");
    exit();
}
$id=$_SESSION['id'];
$rol=$_SESSION['Idrol'];


include('archivos\vista\quien.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="mb-4">Bienvenido, Cliente</h2>

    <!-- FORMULARIO DE RESERVAS -->
    <div class="card mb-4">
        <div class="card-header">Reservar una mesa</div>
        <div class="card-body">
            <form method="POST" action="reservar.php">
                <div class="mb-3">
                    <label>Mesa disponible:</label>
                    <select name="id_mesa" class="form-select" required>
                        <option value="">Seleccione una mesa</option>
                        <?php while($mesa = mysqli_fetch_assoc($queryMesas)) { ?>
                            <option value="<?= $mesa['id_mesa'] ?>">
                                <?= $mesa['nombre_mesa'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Fecha:</label>
                    <input type="date" name="fecha" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Hora inicio:</label>
                    <input type="time" name="hora_inicio" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Hora fin:</label>
                    <input type="time" name="hora_fin" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Reservar</button>
            </form>
        </div>
    </div>

    <!-- FORMULARIO DE COMENTARIOS -->
    <div class="card">
        <div class="card-header">Comentar un plato</div>
        <div class="card-body">
            <form method="POST" action="comentario.php">
                <div class="mb-3">
                    <label>Plato:</label>
                    <select name="id_plato" class="form-select" required>
                        <option value="">Seleccione un plato</option>
                        <?php while($plato = mysqli_fetch_assoc($queryPlatos)) { ?>
                            <option value="<?= $plato['id_plato'] ?>">
                                <?= $plato['nombre_plato'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Comentario:</label>
                    <textarea name="comentario" class="form-control" rows="4"></textarea>
                </div>
                <div class="mb-3">
                    <label>Puntuación (1 a 5):</label>
                    <input type="number" name="puntuacion" class="form-control" min="1" max="5" required>
                </div>
                <button type="submit" class="btn btn-success">Enviar Comentario</button>
            </form>
        </div>
    </div>

    <!-- Cerrar sesión -->
    <div class="mt-4">
        <a href="cerrarsesion.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>
</div>

</body>
</html>
