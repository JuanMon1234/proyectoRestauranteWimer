<?php
require_once(__DIR__ . "/../../include/config.php");
require_once(__DIR__ . "/../../include/funciones.php");

session_name($session_name);
session_start();

if (!isset($_SESSION['Idusuario']) || $_SESSION['idrol'] != 1) {
    header("Location: ../../index.php");
    exit();
}

$idrol = intval($_POST['idrol'] ?? 0);

if ($idrol <= 0) {
    echo "Rol inválido.";
    exit();
}

$conn = conex();

// 1. Obtener información del rol
$sqlRol = "SELECT idrol, Nombre FROM roles WHERE idrol = $idrol LIMIT 1";
$resRol = mysqli_query($conn, $sqlRol);
$rol = mysqli_fetch_assoc($resRol);

// 2. Obtener permisos actuales
$permisos_rol = [];
$sqlPermisos = "SELECT idmenu, idsubmenu, es_area FROM permisos_rol WHERE idrol = $idrol AND permitido = 1";
$resultPermisos = mysqli_query($conn, $sqlPermisos);
while ($row = mysqli_fetch_assoc($resultPermisos)) {
    if ($row['es_area'] == 1) {
        $permisos_rol['menu_'.$row['idmenu']] = true; // Permiso completo al menú
    } else {
        $permisos_rol['submenu_'.$row['idsubmenu']] = true; // Permiso a submenú
    }
}

// 3. Obtener menús y submenús activos
$menus = [];
$sqlMenu = "SELECT idmenu, nombre_menu FROM menu WHERE es_activo = 1 ORDER BY orden ASC";
// Para submenús

$resMenu = mysqli_query($conn, $sqlMenu);

while ($menu = mysqli_fetch_assoc($resMenu)) {
    $menu['submenus'] = [];
    $sqlSubmenu = "SELECT idsubmenu, nombre_submenu FROM submenu 
                WHERE idmenu = {$menu['idmenu']} AND es_activo = 1 
                ORDER BY orden ASC";
    $resSubmenu = mysqli_query($conn, $sqlSubmenu);
    
    while ($submenu = mysqli_fetch_assoc($resSubmenu)) {
        $menu['submenus'][] = $submenu;
    }
    
    $menus[] = $menu;
}

mysqli_close($conn);
?>

<!-- Formulario de permisos (se incrusta en el modal) -->
<form id="formPermisos" method="post">
    <input type="hidden" name="idrol" value="<?= $rol['idrol'] ?>">

    <div class="accordion" id="accordionPermisos">
        <?php foreach ($menus as $index => $menu): ?>
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading<?= $index ?>">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                        data-bs-target="#collapse<?= $index ?>" aria-expanded="true" 
                        aria-controls="collapse<?= $index ?>">
                    <?= htmlspecialchars($menu['nombre_menu']) ?>
                    <?php if (isset($permisos_rol['menu_'.$menu['idmenu']])): ?>
                        <span class="badge bg-success ms-2">Todo el menú</span>
                    <?php endif; ?>
                </button>
            </h2>
            <div id="collapse<?= $index ?>" class="accordion-collapse collapse show" 
                aria-labelledby="heading<?= $index ?>" data-bs-parent="#accordionPermisos">
                <div class="accordion-body">
                    <!-- Checkbox para acceso completo -->
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input menu-completo" type="checkbox" 
                            id="menu_<?= $menu['idmenu'] ?>" 
                            data-menu="<?= $menu['idmenu'] ?>"
                            <?= isset($permisos_rol['menu_'.$menu['idmenu']]) ? 'checked' : '' ?>>
                        <label class="form-check-label fw-bold" for="menu_<?= $menu['idmenu'] ?>">
                            Acceso completo a este menú
                        </label>
                    </div>

                    <!-- Submenús -->
                    <?php if (!empty($menu['submenus'])): ?>
                        <h6 class="mb-3">Permisos específicos:</h6>
                        <?php foreach ($menu['submenus'] as $submenu): ?>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input submenu-permiso" type="checkbox" 
                                    name="permisos[submenu][]" 
                                    value="<?= $submenu['idsubmenu'] ?>" 
                                    id="submenu_<?= $submenu['idsubmenu'] ?>"
                                    data-menu="<?= $menu['idmenu'] ?>"
                                    <?= isset($permisos_rol['submenu_'.$submenu['idsubmenu']]) ? 'checked' : '' ?>
                                    <?= isset($permisos_rol['menu_'.$menu['idmenu']]) ? 'disabled' : '' ?>>
                                <label class="form-check-label" for="submenu_<?= $submenu['idsubmenu'] ?>">
                                    <?= htmlspecialchars($submenu['nombre_submenu']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-primary">Guardar permisos</button><!--este es guardar interno el que si funciona-->
    </div>
</form>