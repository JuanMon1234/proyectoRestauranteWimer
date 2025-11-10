<?php
namespace IncludeDB;

class Conexion
{
    public static function conexion()
    {
        $DB = include __DIR__ . "/DB.php";

        $conexion = mysqli_connect(
            $DB['DB_HOST'],
            $DB['DB_USER'],
            $DB['DB_PASS'],
            $DB['DB_NAME'],
            $DB['DB_PORT']
        );

        if (!$conexion) {
            die("❌ Error de conexión: " . mysqli_connect_error());
        }
        return $conexion;
    }
}
