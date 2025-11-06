<?php
require_once("../../include/config.php");
require_once("../../include/funciones.php");

header('Content-Type: application/json; charset=utf-8');

$id = intval($_POST['id']);

if ($id > 0) {
    $res = ejecutarConsulta("DELETE FROM usuarios WHERE Idusuario = $id");
    if ($res) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Usuario eliminado correctamente.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No se pudo eliminar el usuario.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'ID inválido.'
    ]);
}
exit;
