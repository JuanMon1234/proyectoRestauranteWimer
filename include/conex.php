<?php
function conex()
{
    $servername = "localhost"; // usa socket en lugar de TCP/IP
    $username   = "root";
    $password   = "";  // en XAMPP root casi siempre no tiene clave
    $db         = "restaurante";
	$port = 3307; // Puerto por defecto de MySQL es 3306, pero en XAMPP es 3307

    $conEctar = mysqli_connect($servername, $username, $password, $db, $port);

    if (!$conEctar) {
        die("❌ Error de Conexión: " . mysqli_connect_error());
    }
    return $conEctar;
}
?>
