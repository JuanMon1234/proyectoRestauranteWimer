<?php
session_start();
if (!isset($_SESSION['idrol']) || $_SESSION['idrol'] != 2) {
    header("Location: index.php?k=4");
    exit();
}
include('../../include/conex.php');
$conexion = conex();
$query = "SELECT * FROM ingredientes";
$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Ingredientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2>📋 Lista de Ingredientes</h2>
    <a href="agregar_ingrediente.php" class="btn btn-success mb-3">➕ Agregar Ingrediente</a>

    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Calorías</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td><?php echo $row['id_ingrediente']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['calorias']; ?></td>
                <td><a href="borrar_ingrediente.php?id=<?php echo $row['id_ingrediente']; ?>" class="btn btn-danger btn-sm">Borrar</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
