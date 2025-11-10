<?php

use IncludeDB\Conexion;

session_start();
if (!isset($_SESSION['Idrol']) || $_SESSION['Idrol'] != 2) {
    header("Location: index.php?k=4");
    exit();
}

include("../../include/conex.php");
$conexion = Conexion::conexion();

// Función para obtener recetas por tipo
function obtenerRecetasPorTipo($conexion, $tipo) {
    $sql = "SELECT r.id_receta, p.nombre 
            FROM recetas r
            INNER JOIN platos p ON r.id_plato = p.id_plato
            WHERE r.tipo_plato = ?";
    
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $tipo);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    $recetas = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $recetas[] = $fila;
    }
    return $recetas;
}

// Si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre_plato'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $disponible = isset($_POST['disponible']) ? 1 : 0;

    $sql = "INSERT INTO menus (nombre_plato, descripcion, precio, disponible) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ssdi", $nombre, $descripcion, $precio, $disponible);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Menú agregado correctamente'); window.location.href='menus.php';</script>";
    } else {
        echo "<script>alert('Error al agregar menú');</script>";
    }
}

// Obtener listas
$entradas = obtenerRecetasPorTipo($conexion, "Entrada");
$fuerte = obtenerRecetasPorTipo($conexion, "Fuerte");
$postres = obtenerRecetasPorTipo($conexion, "Postre");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Menú</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>🍽️ Agregar Nuevo Menú</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="nombre_plato" class="form-label">Nombre del Menú</label>
            <input type="text" name="nombre_plato" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" name="precio" class="form-control" step="0.01" required>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="disponible" id="disponible" checked>
            <label class="form-check-label" for="disponible">Disponible</label>
        </div>

        <h5>🍽️ Seleccionar Platos (Opcional - si deseas enlazar después)</h5>
        <div class="mb-3">
            <label class="form-label">Entrada</label>
            <select class="form-select" name="entrada_id" disabled>
                <option selected>Seleccionar</option>
                <?php foreach ($entradas as $e) { ?>
                    <option value="<?php echo $e['id_receta']; ?>"><?php echo $e['nombre']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Plato Fuerte</label>
            <select class="form-select" name="fuerte_id" disabled>
                <option selected>Seleccionar</option>
                <?php foreach ($fuerte as $f) { ?>
                    <option value="<?php echo $f['id_receta']; ?>"><?php echo $f['nombre']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Postre</label>
            <select class="form-select" name="postre_id" disabled>
                <option selected>Seleccionar</option>
                <?php foreach ($postres as $p) { ?>
                    <option value="<?php echo $p['id_receta']; ?>"><?php echo $p['nombre']; ?></option>
                <?php } ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Agregar Menú</button>
        <a href="menus.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
</body>
</html>
