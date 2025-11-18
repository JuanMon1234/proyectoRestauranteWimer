<?php

use IncludeDB\Conexion;

header('Content-Type: application/json');
require_once __DIR__ . "/../../include/config.php" ;
require_once __DIR__ . "/../../include/funciones.php";

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
$permisos_menu = $_POST['permisos_menu'] ?? [];
$permisos_submenu = $_POST['permisos_submenu'] ?? [];

$conn = Conexion::conexion();
$conn->begin_transaction();

try {

    // ✅ 1. Eliminar permisos anteriores con sentencia preparada
    $stmt = $conn->prepare("DELETE FROM permisos_rol WHERE idrol = ?");
    $stmt->bind_param("i", $idrol);
    $stmt->execute();

    // ✅ 2. Insertar permisos de menú completo
    $stmt_menu = $conn->prepare(
        "INSERT INTO permisos_rol (idrol, idmenu, idsubmenu, permitido, es_area) VALUES (?, ?, NULL, 1, 1)"
    );

    foreach ($permisos_menu as $idmenu) {
        $idmenu = intval($idmenu);
        $stmt_menu->bind_param("ii", $idrol, $idmenu);
        $stmt_menu->execute();
    }

    // ✅ 3. Insertar permisos de submenús
    $stmt_submenu_select = $conn->prepare(
        "SELECT idmenu FROM submenu WHERE idsubmenu = ? AND es_activo = 1 LIMIT 1"
    );

    $stmt_submenu_insert = $conn->prepare(
        "INSERT INTO permisos_rol (idrol, idmenu, idsubmenu, permitido, es_area) VALUES (?, ?, ?, 1, 0)"
    );

    foreach ($permisos_submenu as $idsubmenu) {
        $idsubmenu = intval($idsubmenu);

        // Obtener idmenu del submenú
        $stmt_submenu_select->bind_param("i", $idsubmenu);
        $stmt_submenu_select->execute();
        $res = $stmt_submenu_select->get_result();

        if ($row = $res->fetch_assoc()) {
            $idmenu_padre = $row['idmenu'];
            $stmt_submenu_insert->bind_param("iii", $idrol, $idmenu_padre, $idsubmenu);
            $stmt_submenu_insert->execute();
        }
    }

    // ✅ Confirmación de transacción
    $conn->commit();
    echo json_encode(['success' => true]);

} catch (Exception $e) {

    // ❌ Algo falló, revertir
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);

} finally {

    $conn->close();
}