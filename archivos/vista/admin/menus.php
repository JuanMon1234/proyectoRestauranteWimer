<?php
session_start();

// ✅ 1. Verificar que la sesión esté activa y el rol sea válido
if (!isset($_SESSION['Idrol']) || $_SESSION['Idrol'] != 2) {
    header("Location: index.php?k=4");
    exit();
}

// ✅ 2. Incluir conexión de forma segura
require_once __DIR__ . '/../../include/conex.php';
$conexion = conex();

// ✅ 3. Verificar conexión a la base de datos
if (!$conexion) {
    error_log("Error de conexión a la base de datos: " . mysqli_connect_error());
    die("Error al conectar con la base de datos.");
}

// ✅ 4. Usar consultas preparadas (buen hábito, incluso sin variables)
$query = "SELECT * FROM menus";
$stmt = mysqli_prepare($conexion, $query);

if (!$stmt) {
    error_log("Error al preparar consulta: " . mysqli_error($conexion));
    die("Error interno. Intente más tarde.");
}

// ✅ 5. Ejecutar la consulta y obtener resultados
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

// ✅ 6. Manejar posibles errores en la ejecución
if (!$resultado) {
    error_log("Error al ejecutar consulta: " . mysqli_error($conexion));
    die("No se pudieron obtener los datos.");
}

// ✅ 7. Procesar los datos (ejemplo)
while ($fila = mysqli_fetch_assoc($resultado)) {
    echo htmlspecialchars($fila['nombre_menu']); // Ejemplo de salida segura
}

// ✅ 8. Cerrar recursos
mysqli_stmt_close($stmt);
mysqli_close($conexion);
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
