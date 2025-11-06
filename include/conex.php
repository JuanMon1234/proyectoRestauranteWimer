<?php
namespace Include;

class Conexion {
    public static function crear() {
        $conexion = mysqli_connect("localhost", "usuario", "clave", "basedatos");
        if (!$conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }
        return $conexion;
    }
}
