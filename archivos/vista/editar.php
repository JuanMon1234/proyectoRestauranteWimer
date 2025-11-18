<?php

require_once __DIR__ . "/../../include/config.php";
require_once __DIR__ . "/../../include/conex.php";
require_once __DIR__ . "/../../include/funciones.php";
require_once __DIR__ . "/../../herramientas/llave/llave.php";

session_name($session_name);
session_start();
// Obtener ID de forma segura
$id = ($_SERVER['REQUEST_METHOD'] === 'POST')
        ? intval($_POST['Idusuario'])
        : intval($_GET['id']);

// -----------------------
// TRAER DATOS DEL USUARIO
// -----------------------
$sql = "SELECT * FROM usuarios WHERE Idusuario = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($result);

// -----------------------
// PROCESAR ACTUALIZACIÓN
// -----------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombres        = trim($_POST['nombres']);
    $apellidos      = trim($_POST['apellidos']);
    $correo         = trim($_POST['correo']);
    $identificacion = trim($_POST['identificacion']);
    $celular        = trim($_POST['celular']);
    $rol            = intval($_POST['idrol']);
    $estado         = trim($_POST['estado']);

    $update = "
        UPDATE usuarios SET 
        Nombres = ?, Apellidos = ?, Correo = ?, Identificacion = ?, Celular = ?, idrol = ?, estado = ?WHERE Idusuario = ?";
    $stmt2 = mysqli_prepare($link, $update);

    mysqli_stmt_bind_param(
        $stmt2,
        "ssssssis",
        $nombres,
        $apellidos,
        $correo,
        $identificacion,
        $celular,
        $rol,
        $estado,
        $id
    );

    $ok = mysqli_stmt_execute($stmt2);

    if ($ok) {
        echo "<div class='alert alert-success'>Usuario actualizado correctamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar usuario.</div>";
    }

    exit;
}
?>

<!-- Formulario parcial para modal -->
<form id="formEditarUsuario">
    <!-- Input hidden con el ID del usuario -->
    <input type="hidden" name="Idusuario" value="<?= $usuario['Idusuario'] ?>">

    <div class="mb-3">
        <label>Nombres</label>
        <input type="text" name="nombres" class="form-control" value="<?= $usuario['Nombres'] ?>" required>
    </div>

    <div class="mb-3">
        <label>Apellidos</label>
        <input type="text" name="apellidos" class="form-control" value="<?= $usuario['Apellidos'] ?>" required>
    </div>

    <div class="mb-3">
        <label>Correo</label>
        <input type="email" name="correo" class="form-control" value="<?= $usuario['Correo'] ?>" required>
    </div>

    <div class="mb-3">
        <label>Identificación</label>
        <input type="text" name="identificacion" class="form-control" value="<?= $usuario['Identificacion'] ?>" required>
    </div>

    <div class="mb-3">
        <label>Celular</label>
        <input type="text" name="celular" class="form-control" value="<?= $usuario['Celular'] ?>">
    </div>

    <div class="mb-3">
        <label>Rol</label>
        <select name="idrol" class="form-select" required>
            <?php
            $roles = ejecutarConsultaSegura("SELECT idrol, Nombre FROM roles");
            while ($r = mysqli_fetch_assoc($roles)) {
                $sel = $usuario['idrol'] == $r['idrol'] ? "selected" : "";
                echo "<option value='{$r['idrol']}' $sel>{$r['Nombre']}</option>";
            }
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Estado</label>
        <select name="estado" class="form-select">
            <option value="pendiente" <?= $usuario['estado'] == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
            <option value="activo" <?= $usuario['estado'] == 'activo' ? 'selected' : '' ?>>Activo</option>
            <option value="inactivo" <?= $usuario['estado'] == 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
        </select>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-success">Actualizar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    </div>
</form>
