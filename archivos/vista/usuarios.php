<?php
require_once __DIR__ . "/../../include/config.php";
require_once __DIR__ . "/../../include/funciones.php";

session_name($session_name);
session_start();

if (!isset($_SESSION['usuarioLogueado'])) {
    header("Location: ../../login.php");
    exit();
}

// Traer todos los usuarios con su rol y estado
$sql = "SELECT u.Idusuario, u.Nombres, u.Apellidos, u.Identificacion, 
        u.Correo, u.Celular, u.estado, r.idrol, r.Nombre AS nombre_rol
        FROM usuarios u
        INNER JOIN roles r ON u.idrol = r.idrol";
$result = ejecutarConsultaSegura($sql);

$usuarios = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($fila = mysqli_fetch_assoc($result)) {
        $usuarios[] = $fila;
    }
}
?>

<?php include_once("../../include/header.php"); ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../../estilo/css/admin.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>
<body>

<div class="admin-container">
    <?php include_once "../../include/navbar.php"; ?>

    <main class="main-content p-4">
        <div class="admin-header mb-4">
            <h1>Gestión de Usuarios</h1>
            <p class="lead">Ver, buscar, agregar y administrar usuarios del sistema</p>
        </div>

        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <h5 class="mb-0">Listado de Usuarios</h5>
                <div>
                    <button class="btn btn-light btn-sm" id="btnExportar">
                        <i class="fas fa-file-export"></i> Exportar
                    </button>
                    <button class="btn btn-success btn-agregar">
                        <i class="fas fa-plus"></i> Agregar
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tablaUsuarios">
                        <thead>
                            <tr class="table-dark">
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Documento</th>
                                <th>Celular</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($usuarios)): ?>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($usuario['Idusuario']) ?></td>
                                        <td><?= htmlspecialchars($usuario['Nombres'] . " " . $usuario['Apellidos']) ?></td>
                                        <td><?= htmlspecialchars($usuario['Correo']) ?></td>
                                        <td><?= htmlspecialchars($usuario['nombre_rol']) ?></td>
                                        <td><?= htmlspecialchars($usuario['Identificacion']) ?></td>
                                        <td><?= htmlspecialchars($usuario['Celular']) ?></td>
                                        <td>
                                            <select class="form-select form-select-sm cambiar-estado" data-id="<?= $usuario['Idusuario'] ?>">
                                                <option value="pendiente" <?= $usuario['estado'] == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                                <option value="activo" <?= $usuario['estado'] == 'activo' ? 'selected' : '' ?>>Activo</option>
                                                <option value="inactivo" <?= $usuario['estado'] == 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-warning btn-editar" data-id="<?= $usuario['Idusuario'] ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger btn-eliminar" data-id="<?= $usuario['Idusuario'] ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">No hay usuarios registrados</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Modal para Agregar Usuario -->
    <div class="modal fade" id="modalAgregar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Agregar Usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" id="contenidoModalAgregar">
            <!-- Formulario cargado vía AJAX -->
        </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header bg-warning text-dark">
            <h5 class="modal-title">Editar Usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" id="contenidoModalEditar">
            <!-- Formulario cargado vía AJAX -->
        </div>
        </div>
    </div>
    </div>


<!-- jQuery primero -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Luego DataTables -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- Por último tu script -->
<script src="../../estilo/js/usuarios.js"></script>

</body>
</html>
