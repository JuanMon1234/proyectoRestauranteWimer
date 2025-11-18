<?php
namespace IncludeDB;

class Conexion
{
    public static function conexion()
    {
        $config = include_once __DIR__ . ("/DB.php");

        $conexion = mysqli_connect(
            $config['DB_HOST'],
            $config['DB_USER'], $config['DB_PASS'],$config['DB_NAME'],$config['DB_PORT'],);
        if (!$conexion) {
            die("❌ Error de conexión: " . mysqli_connect_error());
        }
        return $conexion;
    }
}
