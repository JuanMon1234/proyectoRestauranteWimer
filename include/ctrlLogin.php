<?php

use IncludeDB\Conexion;

require_once 'config.php';
require_once 'conex.php';
function getNombreRol($idRol) {
    $roles = [
        1 => 'Administrador',
        2 => 'Chef',
        3 => 'Mesero',
        4 => 'Cajero',
        5 => 'Cliente'
    ];

    return $roles[$idRol] ?? 'Desconocido';
}


header('Content-Type: application/json; charset=' . $charset);
header('Cache-Control: no-cache, must-revalidate');

session_name($session_name);
session_start();

$conEctar = Conexion::conexion();

switch ($_REQUEST['action']) {

    // 1. Cargar tipos de documento
    case 'selectTipoD':
        $jTableResult = ['msj' => "", 'rspst' => "", 'optionTipoDocumento' => ""];
        $query = "SELECT Idtipodoc, TipoDoc FROM tipodoc";
        $reg = mysqli_query($conEctar, $query);
        while ($registro = mysqli_fetch_assoc($reg)) {
            $jTableResult['optionTipoDocumento'] .= "<option value='" . $registro['Idtipodoc'] . "'>" . $registro['TipoDoc'] . "</option>";
        }
        print json_encode($jTableResult);
        break;

    // 2. Cargar roles desde la base de datos
    case 'selectRoles':
        // Ejemplo: consulta a base de datos o array con roles
    $roles = [
        ['id' => 1, 'nombre' => 'Administrador'],
        ['id' => 2, 'nombre' => 'Chef'],
        ['id' => 3, 'nombre' => 'Mesero'],
        ['id' => 4, 'nombre' => 'Cajero'],
        ['id' => 5, 'nombre' => 'Cliente']
    ];

    $options = '<option value="" disabled selected>Seleccione su rol</option>';
    foreach ($roles as $rol) {
        $options .= "<option value=\"{$rol['id']}\">{$rol['nombre']}</option>";
    }

    echo json_encode(['optionRoles' => $options]);
    break;
        

    // 3. Iniciar sesión
    case 'iniciar':
    $jTableResult = ['msj' => "", 'rspst' => ""];
    $correo = trim($_POST['correo'] ?? '');
    $clave = trim($_POST['clave'] ?? '');
    $rol = intval($_POST['rol'] ?? 0);

    if (!empty($correo) && !empty($clave) && $rol > 0) {
        $correo_escapado = mysqli_real_escape_string($conEctar, $correo);

        $query = "SELECT Idusuario, Correo, Nombres, Apellidos, Clave, idrol, estado 
                FROM usuarios
                WHERE Correo = '$correo_escapado' AND idrol = $rol";

        $registros = mysqli_query($conEctar, $query);
        if (mysqli_num_rows($registros) > 0) {
            $regis = mysqli_fetch_assoc($registros);

            if ($regis['estado'] !== 'activo') {
                $jTableResult['rspst'] = "0";
                $jTableResult['msj'] = "USUARIO NO ACTIVADO POR EL ADMINISTRADOR";
            } else if (password_verify($clave, $regis['Clave'])) {
                // Login correcto
                $_SESSION['Idusuario'] = $regis['Idusuario'];
                $_SESSION['Correo'] = $regis['Correo'];
                $_SESSION['usuarioLogueado'] = $regis['Nombres'] . " " . $regis['Apellidos'];
                $_SESSION['idrol'] = $regis['idrol'];
                $_SESSION['rol_nombre'] = getNombreRol($regis['idrol']); // si tienes una función o array para mapear
                $_SESSION['LAST_ACTIVITY'] = time(); // Seguridad por inactividad
                $_SESSION['IP'] = $_SERVER['REMOTE_ADDR'];
                $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

                $jTableResult['rspst'] = "1";
                $jTableResult['msj'] = "INGRESO EXITOSO";
            } else {
                $jTableResult['rspst'] = "0";
                $jTableResult['msj'] = "CONTRASEÑA INCORRECTA";
            }
        } else {
            $jTableResult['rspst'] = "0";
            $jTableResult['msj'] = "CORREO O ROL INCORRECTOS";
        }
    } else {
        $jTableResult['rspst'] = "0";
        $jTableResult['msj'] = "FALTAN DATOS PARA INICIAR SESIÓN";
    }

    print json_encode($jTableResult);
    break;


    // 4. Verificar cédula
    case 'verificarCedula':
        $jTableResult = ['existe' => false];
        $identificacion = trim($_POST['identificacion'] ?? '');
        
        if (!empty($identificacion)) {
            $identificacion_escapada = mysqli_real_escape_string($conEctar, $identificacion);
            $query = "SELECT Idusuario FROM usuarios WHERE Identificacion = '$identificacion_escapada'";
            $registros = mysqli_query($conEctar, $query);
            $jTableResult['existe'] = (mysqli_num_rows($registros) > 0);
        }
        print json_encode($jTableResult);
        break;

    // 5. Registrar usuario
    case 'registrarUsuario':
        $jTableResult = ['msj' => "", 'rspst' => ""];
        $identificacion = trim($_POST['identificacion'] ?? '');
        $correo = trim($_POST['correoregistro'] ?? '');
        $idrol = intval($_POST['rol'] ?? 0);
        $tipodoc = intval($_POST['idTipoDocumento'] ?? 0);
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $celular = trim($_POST['telefono'] ?? '');
        $clave = trim($_POST['claveregistro'] ?? '');

        if (!$identificacion || !$correo || !$idrol || !$tipodoc || !$nombre || !$apellido || !$clave) {
            $jTableResult['rspst'] = "0";
            $jTableResult['msj'] = "TODOS LOS CAMPOS SON OBLIGATORIOS";
            print json_encode($jTableResult);
            break;
        }

        // Verificar cédula y correo
        $query = "SELECT Idusuario FROM usuarios WHERE Identificacion = '" . mysqli_real_escape_string($conEctar, $identificacion) . "'";
        if (mysqli_num_rows(mysqli_query($conEctar, $query)) > 0) {
            $jTableResult['rspst'] = "0";
            $jTableResult['msj'] = "LA CÉDULA YA ESTÁ REGISTRADA";
            print json_encode($jTableResult);
            break;
        }

        $query = "SELECT Idusuario FROM usuarios WHERE Correo = '" . mysqli_real_escape_string($conEctar, $correo) . "'";
        if (mysqli_num_rows(mysqli_query($conEctar, $query)) > 0) {
            $jTableResult['rspst'] = "0";
            $jTableResult['msj'] = "EL CORREO YA ESTÁ REGISTRADO";
            print json_encode($jTableResult);
            break;
        }

        $clave_hash = password_hash($clave, PASSWORD_DEFAULT);

        $query = "INSERT INTO usuarios 
                (Nombres, Apellidos, Identificacion, Correo, Clave, Celular, idrol, Idtipodoc, estado)
                VALUES 
                ('" . mysqli_real_escape_string($conEctar, $nombre) . "',
                '" . mysqli_real_escape_string($conEctar, $apellido) . "',
                '" . mysqli_real_escape_string($conEctar, $identificacion) . "',
                '" . mysqli_real_escape_string($conEctar, $correo) . "',
                '$clave_hash',
                '" . mysqli_real_escape_string($conEctar, $celular) . "',
                $idrol,
                $tipodoc,
                'pendiente')";

        if (mysqli_query($conEctar, $query)) {
            $jTableResult['rspst'] = "1";
            $jTableResult['msj'] = "REGISTRO REALIZADO CON ÉXITO";
        } else {
            $jTableResult['rspst'] = "0";
            $jTableResult['msj'] = "ERROR AL REGISTRAR USUARIO: " . mysqli_error($conEctar);
        }

        print json_encode($jTableResult);
        break;

    // 6. Cerrar sesión
    case 'salir':
        session_unset();
        session_destroy();
        print json_encode(['rspst' => "1"]);
        break;

    default:
        print json_encode(['rspst' => "0", 'msj' => "ACCIÓN NO VÁLIDA"]);
        break;
}

mysqli_close($conEctar);
?>
