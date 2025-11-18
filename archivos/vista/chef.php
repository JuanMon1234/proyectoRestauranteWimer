<?php

require_once "../../include/config.php";
require_once "../../include/conex.php";
require_once "../../include/funciones.php";
session_name($session_name);
session_start();

// Validar sesión y rol de Chef (rol = 2)
if (!isset($_SESSION['Idusuario']) || $_SESSION['idrol'] != 2) {
    header("Location: ../../../index.php");
    exit();
}

$nombre = $_SESSION['nombre'] ?? 'Chef';
$idRol = $_SESSION['idrol'];
// Traer pedidos activos del chef
$sqlPedidos = "SELECT p.Idpedidos, p.fecha, p.estado, u.Nombres AS cliente 
                FROM pedidos p 
                INNER JOIN usuarios u ON p.Idusuarios = u.Idusuario 
                WHERE p.estado = 'activo'";
$resultPedidos = ejecutarConsultaSegura($sqlPedidos);
$pedidos = [];
if ($resultPedidos && mysqli_num_rows($resultPedidos) > 0) {
    while ($fila = mysqli_fetch_assoc($resultPedidos)) {
        $pedidos[] = $fila;
    }
}
?>

<?php include_once "../../include/header.php"; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="../../estilo/css/admin.css">

<style>
    /* Estilos similares al panel de Chef que ya tenías */
    .chef-container { display: flex; min-height: 100vh; }
    .main-content { flex: 1; padding: 20px; background-color: #f8f9fa; margin-left: 250px; transition: margin 0.3s ease; }
    .chef-header { margin-bottom: 30px; padding: 20px; background-color: #631c82ff; color: white; border-radius: 8px; }
    .card-chef { transition: all 0.3s ease; border: none; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08); height: 100%; border-top: 4px solid #8e44ad; }
    .card-chef:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.12); }
    .card-chef .card-body { padding: 1.8rem; text-align: center; }
    .chef-icon { font-size: 2.2rem; margin-bottom: 1.2rem; color: #8e44ad; transition: transform 0.3s; }
</style>

<body>
<div class="chef-container">
    <?php include_once "../../include/navbar.php"; ?>

    <main class="main-content">
        <div class="chef-header">
            <h1><i class="fas fa-utensils me-2"></i>Panel del Chef</h1>
            <p class="lead">Bienvenido, <?= htmlspecialchars($nombre) ?></p>
        </div>

        <!-- Tarjetas de acceso rápido -->
        <div class="dashboard-cards row g-4">
            <div class="col-md-3 col-6">
                <div class="card card-chef h-100">
                    <div class="card-body">
                        <div class="chef-icon"><i class="fas fa-book-open"></i></div>
                        <h5 class="card-title">Recetas</h5>
                        <p class="card-text">Administra tus recetas</p>
                        <a href="recetas.php" class="btn btn-outline-primary btn-sm stretched-link"><i class="fas fa-arrow-right me-1"></i> Acceder</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="card card-chef h-100">
                    <div class="card-body">
                        <div class="chef-icon"><i class="fas fa-concierge-bell"></i></div>
                        <h5 class="card-title">Pedidos Activos</h5>
                        <p class="card-text">Revisa los pedidos pendientes</p>
                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalPedidos">Ver Pedidos</button>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="card card-chef h-100">
                    <div class="card-body">
                        <div class="chef-icon"><i class="fas fa-carrot"></i></div>
                        <h5 class="card-title">Ingredientes</h5>
                        <p class="card-text">Gestiona tu inventario</p>
                        <a href="ingredientes.php" class="btn btn-outline-warning btn-sm stretched-link"><i class="fas fa-edit me-1"></i> Gestionar</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Pedidos -->
        <div class="modal fade" id="modalPedidos" tabindex="-1" aria-labelledby="modalPedidosLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalPedidosLabel"><i class="fas fa-concierge-bell me-2"></i>Pedidos Activos</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-hover" id="tablaPedidos">
                            <thead>
                                <tr>
                                    <th>ID Pedido</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pedidos)): ?>
                                    <?php foreach ($pedidos as $p): ?>
                                    <tr>
                                        <td><?= $p['idpedido'] ?></td>
                                        <td><?= htmlspecialchars($p['cliente']) ?></td>
                                        <td><?= $p['fecha'] ?></td>
                                        <td><?= ucfirst($p['estado']) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center">No hay pedidos activos</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    </main>
</div>

<?php include_once "../../include/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#tablaPedidos').DataTable();

    // Animación iconos
    $('.card-chef').hover(
        function(){ $(this).find('.chef-icon').css('transform', 'scale(1.1)'); },
        function(){ $(this).find('.chef-icon').css('transform', 'scale(1)'); }
    );

    // Notificación de bienvenida
    <?php if(!isset($_SESSION['chef_welcome_shown'])): ?>
    Swal.fire({
        title: '¡Bienvenido, Chef!',
        text: 'Estás en el panel de control de cocina',
        icon: 'success',
        confirmButtonText: 'Comenzar',
        confirmButtonColor: '#8e44ad'
    });
    <?php $_SESSION['chef_welcome_shown'] = true; ?>
    <?php endif; ?>
});
</script>
</body>
</html>
