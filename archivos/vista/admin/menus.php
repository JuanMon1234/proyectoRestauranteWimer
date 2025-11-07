<?php
session_start();

// ✅ 1. Verificar que la sesión esté activa y el rol sea válido
if (!isset($_SESSION['Idrol']) || $_SESSION['Idrol'] != 2) {
    header("Location: index.php?k=4");
    exit();
}

// ✅ 2. Registrar un autoload sencillo para cargar clases automáticamente
spl_autoload_register(function ($clase) {
    $ruta = __DIR__ . '/../../' . str_replace('\\', '/', $clase) . '.php';
    if (file_exists($ruta)) {
        include_once $ruta;
    }
});

// ✅ 3. Importar la clase del namespace IncludeDB
use IncludeDB\conexion;
// ✅ 4. Crear conexión a la base de datos
$conexion = conexion::conexion();

// ✅ 5. Preparar y ejecutar consulta segura
$query = "SELECT * FROM menus";
$stmt = mysqli_prepare($conexion, $query);

if (!$stmt) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
