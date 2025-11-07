<?php
namespace IncludeDB;

class conexion
{
    public static function conexion()
    {
        $servername = "localhost";
        $username   = "root";
        $claveDB   = "";
        $db         = "restaurante";
        $port = 3307;

        $conexion = mysqli_connect($servername, $username, $claveDB, $db, $port);

        if (!$conexion) {
            die("❌ Error de conexión: " . mysqli_connect_error());
        }

        return $conexion;
    }
}
