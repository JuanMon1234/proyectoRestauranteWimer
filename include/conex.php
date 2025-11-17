<?php
namespace IncludeDB;

class Conexion
{
    public static function conexion()
    {
        $Data = include_once __DIR__ . "/DB.php";

        $conexion = mysqli_connect(
            $Data['DB_HOST'],
            $Data['DB_USER'], 
            $Data['DB_PASS'],
            $Data['DB_NAME'],
            $Data['DB_PORT']
        );

        if (!$conexion) {
            die("❌ Error de conexión: " . mysqli_connect_error());
        }
        return $conexion;
    }
}
