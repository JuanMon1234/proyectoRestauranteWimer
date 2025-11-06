<?php
session_start();
if (!isset($_SESSION['Idrol']) || $_SESSION['Idrol'] != 2) {
    header("Location: index.php?k=4");
    exit();
}
include('../../include/conex.php');
$conexion = conex();

$resultado = mysqli_query($conexion, "SELECT * FROM menus");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Menús</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>📋 Menús Disponibles</h2>
    <a href="agregar_menu.php" class="btn btn-success mb-3">➕ Agregar Menú</a>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre del Plato</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Disponible</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td><?php echo $row['id_menu']; ?></td>
                <td><?php echo $row['nombre_plato']; ?></td>
                <td><?php echo $row['descripcion']; ?></td>
                <td><?php echo number_format($row['precio']); ?> COP</td>
                <td><?php echo $row['disponible'] ? 'Sí' : 'No'; ?></td>
                <td>
                    <a href="editar_menu.php?id=<?php echo $row['id_menu']; ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
                    <a href="borrar_menu.php?id=<?php echo $row['id_menu']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?');">🗑️ Borrar</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
