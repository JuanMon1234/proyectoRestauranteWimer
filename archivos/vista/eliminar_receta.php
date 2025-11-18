<?php
require_once "../../include/config.php";
require_once "../../include/conex.php";
require_once "../../include/funciones.php";

header('Content-Type: application/json');

$id = intval($_POST['id']);
if($id > 0){
    $res = ejecutarConsultaSegura("DELETE FROM recetas WHERE id_receta = $id");
    if($res){
        echo json_encode(['status'=>'success','message'=>'Receta eliminada correctamente.']);
    }else{
        echo json_encode(['status'=>'error','message'=>'No se pudo eliminar la receta.']);
    }
}else{
    echo json_encode(['status'=>'error','message'=>'ID inválido.']);
}
exit;
