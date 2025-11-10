<?php

use IncludeDB\Conexion;

require_once(__DIR__ . "/../../include/config.php");
require_once(__DIR__ . "/../../include/conex.php");
require_once(__DIR__ . "/../../include/funciones.php");

session_name($session_name);
session_start();

// Validar sesión y rol de Chef (rol = 2)
if (!isset($_SESSION['Idusuario']) || $_SESSION['idrol'] != 2) {
    header("Location: ../../../index.php");
    exit();
}

// Traer todas las recetas
$sql = "SELECT r.id_receta, r.id_plato, r.tiempo_total, r.fuente, r.ubicacion_fisica, 
        r.tipo_plato, r.ingrediente_principal, r.precio, r.comentario_personal 
        FROM recetas r";
$result = mysqli_query(Conexion::conexion(), $sql);

$recetas = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($fila = mysqli_fetch_assoc($result)) {
        $recetas[] = $fila;
    }
}
?>

<?php include_once("../../include/header.php"); ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../../estilo/css/admin.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<body>
<div class="admin-container">
    <?php include_once("../../include/navbar.php"); ?>

    <main class="main-content p-4">
        <div class="admin-header mb-4">
            <h1>Gestión de Recetas</h1>
            <p class="lead">Ver, buscar, agregar y administrar recetas del sistema</p>
        </div>

        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <h5 class="mb-0">Listado de Recetas</h5>
                <div>
                    <button class="btn btn-success btn-agregar" id="btnAgregarReceta">
                        <i class="fas fa-plus"></i> Agregar
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tablaRecetas">
                        <thead>
                            <tr class="table-dark">
                                <th>ID</th>
                                <th>ID Plato</th>
                                <th>Tiempo</th>
                                <th>Fuente</th>
                                <th>Ubicación</th>
                                <th>Tipo de Plato</th>
                                <th>Ingrediente</th>
                                <th>Precio</th>
                                <th>Comentario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recetas)): ?>
                                <?php foreach ($recetas as $receta): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($receta['id_receta']) ?></td>
                                        <td><?= htmlspecialchars($receta['id_plato']) ?></td>
                                        <td><?= htmlspecialchars($receta['tiempo_total']) ?></td>
                                        <td><?= htmlspecialchars($receta['fuente']??'') ?></td>
                                        <td><?= htmlspecialchars($receta['ubicacion_fisica']??'') ?></td>
                                        <td><?= htmlspecialchars($receta['tipo_plato']??'') ?></td>
                                        <td><?= htmlspecialchars($receta['ingrediente_principal']??'') ?></td>
                                        <td><?= htmlspecialchars($receta['precio']??'') ?></td>
                                        <td><?= htmlspecialchars($receta['comentario_personal']??'') ?></td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-warning btn-editar" data-id="<?= $receta['id_receta'] ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger btn-eliminar" data-id="<?= $receta['id_receta'] ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center">No hay recetas registradas</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Modal para Agregar Receta -->
<!-- Modal Agregar Receta -->
<div class="modal fade" id="modalAgregarReceta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="contenidoModalAgregarReceta">
            <!-- Aquí se cargará via AJAX -->
        </div>
    </div>
</div>

<!-- Modal para Editar Receta -->
<div class="modal fade" id="modalEditarReceta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="contenidoModalEditarReceta">
            <!-- Aquí se cargará via AJAX -->
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="../../estilo/js/recetas.js"></script>



</body>
</html>
