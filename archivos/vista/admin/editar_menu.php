<?php

use IncludeDB\Conexion;
include('../../include/conex.php');
$conexion = Conexion::conexion();

$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

if (!$id) {
    die("ID inválido.");
}

// ✅ SELECT seguro
$stmt = $conexion->prepare("SELECT * FROM menus WHERE id_menu = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$menu = $resultado->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre_plato'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $disponible = isset($_POST['disponible']) ? 1 : 0;

    // ✅ UPDATE seguro
    $stmt = $conexion->prepare(
        "UPDATE menus SET nombre_plato = ?, descripcion = ?, precio = ?, disponible = ? WHERE id_menu = ?"
    );
    $stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $disponible, $id);
    $stmt->execute();

    header('Location: menus.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Menú</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>✏️ Editar Menú</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nombre del Plato</label>
            <input type="text" name="nombre_plato" class="form-control" value="<?php echo $menu['nombre_plato']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3"><?php echo $menu['descripcion']; ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Precio</label>
            <input type="number" name="precio" class="form-control" value="<?php echo $menu['precio']; ?>" required>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="disponible" id="disponible" <?php if ($menu['disponible']) echo 'checked'; ?>>
            <label class="form-check-label" for="disponible">Disponible</label>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="menus.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
