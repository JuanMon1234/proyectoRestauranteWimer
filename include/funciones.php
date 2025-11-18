<?php

use IncludeDB\Conexion;

require_once(__DIR__ . '/conex.php');
require_once(__DIR__ . '/config.php');

/**
 * Excepción específica para errores SQL
 */
class ConsultaSqlException extends Exception {}

/**
 * Ejecuta una consulta SQL segura con parámetros
 */
function ejecutarConsultaSegura($sql, $paramTypes = "", $params = []) {
    $conexion = Conexion::conexion();

    $stmt = mysqli_prepare($conexion, $sql);

    if (!$stmt) {
        error_log("Error al preparar consulta: " . mysqli_error($conexion));
        throw new ConsultaSqlException("Error al preparar consulta SQL: " . mysqli_error($conexion));
    }

    if ($paramTypes && !empty($params)) {
        mysqli_stmt_bind_param($stmt, $paramTypes, ...$params);
    }

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);

    return $resultado;
}

/**
 * Verifica si el usuario tiene una sesión válida
 */
function verificarSesion() {
    if (session_status() == PHP_SESSION_NONE) {
        session_name($GLOBALS['session_name']);
        session_start();
    }
    
    // Verifica todos los datos esenciales de la sesión
    $datosRequeridos = ['Idusuario', 'Correo', 'usuarioLogueado', 'idrol'];
    foreach ($datosRequeridos as $dato) {
        if (empty($_SESSION[$dato])) {
            header("Location: /login.php");
            exit();
        }
    }
}

/**
 * Obtiene información de un usuario por su ID
 */
function obtenerUsuario($id) {
    $conexion = Conexion::conexion();
    $stmt = mysqli_prepare($conexion, "SELECT * FROM usuarios WHERE Idusuario = ?");
    
    if (!$stmt) {
        error_log("Error al preparar consulta: " . mysqli_error($conexion));
        return false;
    }
    
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $usuario = mysqli_fetch_assoc($resultado);
    
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
    
    return $usuario;
}

/**
 * Cierra la sesión actual
 */
function cerrarSesion() {
    if (session_status() == PHP_SESSION_NONE) {
        session_name($GLOBALS['session_name']);
        session_start();
    }
    
    $_SESSION = array();
    
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
}
?>