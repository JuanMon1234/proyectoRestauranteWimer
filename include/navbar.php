<?php

use IncludeDB\Conexion;

ini_set('display_errors', 1);
error_reporting(E_ALL);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar sesión
if (!isset($_SESSION['Idusuario'])) {
    header("Location: ../../login.php");
    exit();
}

require_once '../../include/conex.php';
$conn = Conexion::conexion();

// Obtener rol del usuario
$idRol = $_SESSION['idrol'] ?? null;
$nombreUsuario = $_SESSION['usuarioLogueado'] ?? 'Usuario';

// Obtener nombre del rol para mostrar en el sidebar
$sqlRol = "SELECT Nombre FROM roles WHERE idrol = ?";
$stmtRol = $conn->prepare($sqlRol);
$stmtRol->bind_param("i", $idRol);
$stmtRol->execute();
$resultRol = $stmtRol->get_result();
$nombreRol = $resultRol->fetch_assoc()['nombre_rol'] ?? 'Rol';

// Obtener menús permitidos para el rol
$sql = "SELECT m.idmenu, m.nombre_menu, m.ruta, m.icono 
        FROM menu m
        INNER JOIN permisos_rol pr ON m.idmenu = pr.idmenu
        WHERE pr.idrol = ? AND pr.permitido = 1
        ORDER BY m.orden";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idRol);
$stmt->execute();
$result = $stmt->get_result();
$menus = $result->fetch_all(MYSQLI_ASSOC);
?>

<style>
    .sidebar {
        width: 250px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1030;
        overflow-y: auto;
        transition: transform 0.3s ease;
        background-color: <?php 
            // Colores diferentes por rol
            switch($idRol) {
                case 1: echo '#2c3e50'; break; // Admin - Azul oscuro
                case 2: echo '#15a662c0'; break; // Chef - verde
                case 3: echo '#16a085'; break; // Mesero - Verdeazul
                default: echo '#343a40'; // Gris oscuro por defecto
            }
        ?>;
    }

    .sidebar-header {
        background-color: rgba(0,0,0,0.2);
    }

    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }
        .sidebar.show {
            transform: translateX(0);
        }
    }

    .nav-link.active {
        font-weight: 600;
        background-color: rgba(255,255,255,0.1) !important;
    }
</style>

<!-- Botón de menú hamburguesa -->
<button class="toggle-btn btn btn-dark" id="sidebarToggle">
    <i class="fas fa-bars"></i>
</button>

<!-- Menú lateral -->
<nav class="sidebar text-white d-flex flex-column">
    <div class="sidebar-header p-3 text-center">
        <h4 class="mb-0">
            <?php 
            // Iconos diferentes por rol
            switch($idRol) {
                case 1: echo '👑 '; break; // Admin
                case 2: echo '👨‍🍳 '; break; // Chef
                case 3: echo '💁 '; break; // Mesero
            }
            echo htmlspecialchars($nombreRol); 
            ?>
        </h4>
        <small class="text-white-50">Panel</small>
    </div>

    <ul class="nav flex-column px-3 mb-auto">
        <?php 
        $current_page = basename($_SERVER['PHP_SELF']);
        foreach ($menus as $menu): 
            $is_active = (strpos($menu['ruta'], $current_page) !== false);
        ?>
            <li class="nav-item">
                <a class="nav-link text-white <?= $is_active ? 'active' : '' ?>" 
                href="<?= htmlspecialchars($menu['ruta']) ?>">
                    <?php if (!empty($menu['icono'])): ?>
                        <i class="<?= htmlspecialchars($menu['icono']) ?> me-2"></i>
                    <?php endif; ?>
                    <?= htmlspecialchars($menu['nombre_menu']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    
    <div class="sidebar-footer p-3 mt-auto">
        <div class="user-info mb-3">
            <small class="d-block">Bienvenido,</small>
            <strong><?= htmlspecialchars($nombreUsuario) ?></strong>
        </div>
        <button id="navBtnSalir" class="btn btn-outline-light w-100" type="button">
            <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
        </button>
    </div>
</nav>

<div class="overlay" id="sidebarOverlay"></div>

<script>
$(document).ready(function() {
    const sidebar = $('.sidebar');
    const overlay = $('#sidebarOverlay');
    
    // Toggle sidebar
    $('#sidebarToggle').click(function() {
        sidebar.toggleClass('show');
        overlay.toggle();
    });
    
    // Cerrar sidebar al hacer clic en overlay
    overlay.click(function() {
        sidebar.removeClass('show');
        overlay.hide();
    });
    
    // Ajustar al tamaño de pantalla
    $(window).on('resize', function() {
        if ($(window).width() > 768) {
            sidebar.addClass('show');
            overlay.hide();
        }
    }).trigger('resize');
});
</script>