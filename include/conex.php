<?php
namespace IncludeDB;

class Conexion
{
    public static function conectar()
    {
        $servername = "localhost";
        $username   = "root";
        $password   = "TuClave1234";
        $db         = "restaurante";
        $port = 3307;

        $conexion = mysqli_connect($servername, $username, $password, $db, $port);

        if (!$conexion) {
            die("❌ Error de conexión: " . mysqli_connect_error());
        }

        return $conexion;
    }
}
