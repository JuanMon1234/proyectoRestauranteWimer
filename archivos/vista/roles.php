<?php

use IncludeDB\Conexion;

require_once(__DIR__ . "/../../include/config.php");
require_once(__DIR__ . "/../../include/funciones.php");

session_name($session_name);
session_start();

if (!isset($_SESSION['Idusuario']) || $_SESSION['idrol'] != 1) {
    header("Location: ../../index.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'presentarRoles') {
    header('Content-Type: application/json');

    $conn = Conexion::conexion();
    $jTableResult = [];
    $jTableResult['listaRoles'] = "<thead><tr><th>Nombre</th></tr></thead><tbody>";

    $query = "SELECT idrol, Nombre FROM roles ORDER BY Nombre ASC";
    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $jTableResult['listaRoles'] .= "<tr>
                <td>
                    <button type='button' class='btn btn-primary btn-sm btn-rol-permisos' 
                        data-idrol='" . $row['idrol'] . "' 
                        data-nomrerol='" . htmlspecialchars($row['Nombre'], ENT_QUOTES) . "'>
                        " . htmlspecialchars($row['Nombre']) . "
                    </button>
                </td>
            </tr>";
        }
        $jTableResult['listaRoles'] .= "</tbody>";
    } else {
        $jTableResult['listaRoles'] = "<tbody><tr><td>No hay roles</td></tr></tbody>";
    }

    mysqli_close($conn);

    echo json_encode($jTableResult);
    exit();
}
