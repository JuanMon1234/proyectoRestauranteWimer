<?php

use IncludeDB\Conexion;

header('Content-Type: application/json');
require_once(__DIR__ . "/../../include/config.php");
require_once(__DIR__ . "/../../include/funciones.php");

session_name($session_name);
session_start();

if (!isset($_SESSION['Idusuario']) || $_SESSION['idrol'] != 1) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['idrol'])) {
    echo json_encode(['success' => false, 'message' => 'Solicitud inválida']);
    exit;
}

$idrol = intval($_POST['idrol']);
$permisos_menu = $_POST['permisos_menu'] ?? []; // Array de IDs de menús completos
$permisos_submenu = $_POST['permisos_submenu'] ?? []; // Array de IDs de submenús

$conn = Conexion::conexion();
mysqli_begin_transaction($conn);

try {
    // 1. Eliminar permisos anteriores
    mysqli_query($conn, "DELETE FROM permisos_rol WHERE idrol = $idrol");

    // 2. Insertar permisos de menú completo
    foreach ($permisos_menu as $idmenu) {
        $idmenu = intval($idmenu);
        mysqli_query($conn, "INSERT INTO permisos_rol (idrol, idmenu, idsubmenu, permitido, es_area) 
                            VALUES ($idrol, $idmenu, NULL, 1, 1)");
    }

    // 3. Insertar permisos de submenús
    foreach ($permisos_submenu as $idsubmenu) {
        $idsubmenu = intval($idsubmenu);
        // Obtener idmenu del submenú
        $res = mysqli_query($conn, "SELECT idmenu FROM submenu WHERE idsubmenu 
        = $idsubmenu AND es_activo = LIMIT 1");
        if ($res && $row = mysqli_fetch_assoc($res)) {
            mysqli_query($conn, "INSERT INTO permisos_rol (idrol, idmenu, idsubmenu, permitido, es_area) 
                                VALUES ($idrol, {$row['idmenu']}, $idsubmenu, 1, 0)");
        }
    }

    mysqli_commit($conn);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
} finally {
    mysqli_close($conn);
}