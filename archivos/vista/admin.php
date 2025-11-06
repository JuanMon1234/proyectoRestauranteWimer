<?php
// admin.php
require_once("../../include/config.php");
session_name($session_name);
session_start();

// Validar sesión y rol
if (!isset($_SESSION['Idusuario']) || $_SESSION['idrol'] != 1) {
    header("Location: ../../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    
    <!-- Incluir cabecera -->
    <?php include_once("../../include/header.php"); ?>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="../../estilo/css/admin.css"> <!-- Los css siempre se debn llamar con el rel y el href-->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</head>
<body>
    <div class="admin-container">
        <!-- Menú lateral -->
            <?php include_once("../../include/navbar.php"); ?>
        <!-- Contenido principal -->
        <main class="main-content">
            <div class="admin-header">
                <h1><i class="fas fa-cogs me-2"></i>Panel de Administración</h1>
                <p class="lead">Desde aquí puedes gestionar todos los recursos del restaurante</p>
            </div>
            
            <!-- Tarjetas de acceso rápido -->
            <div class="dashboard-cards row g-3">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0"><i class="fas fa-users me-2"></i>Usuarios</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Ver y gestionar usuarios del sistema</p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="usuarios.php" class="btn btn-primary btn-sm">Entrar</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0"><i class="fas fa-user-tag me-2"></i>Roles</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Gestionar roles y permisos de acceso</p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <button type="button" class="btn btn-primary btn-sm" id="btnGestionRoles" data-bs-toggle="modal" data-bs-target="#modalRoles">
                                Gestionar
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0"><i class="fas fa-utensils me-2"></i>Productos</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Administrar menú y platillos</p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="productos.php" class="btn btn-primary btn-sm">Entrar</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0"><i class="fas fa-clipboard-list me-2"></i>Pedidos</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Ver y gestionar pedidos</p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="pedidos.php" class="btn btn-primary btn-sm">Entrar</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal para Gestión de Roles -->
    <div class="modal fade" id="modalRoles" tabindex="-1" aria-labelledby="modalRolesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalRolesLabel">
                        <i class="fas fa-user-tag me-2"></i>Gestión de Roles
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tablaRoles">
                            <thead class="table-light">
                                <tr>
                                    <th>Nombre del Rol</th>
                                </tr>
                            </thead>
                            <tbody id="contenedorRoles">
                                <tr>
                                    <td colspan="1" class="text-center py-4">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Cargando...</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para permisos -->
    <div class="modal fade" id="modalPermisos" tabindex="-1" aria-labelledby="modalPermisosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalPermisosLabel">Asignar Permisos</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" id="contenedorPermisos">
                    <p>Cargando permisos...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <!-- <button type="button" class="btn btn-primary" id="btnGuardarPermisos">Guardar Cambios</button> -->
                </div>
            </div>
        </div>
    </div>

    <?php include_once("../../include/footer.php"); ?>



    <!-- Script para gestión de roles y permisos -->
    <script>
    $(document).ready(function() {
        // 1. Cargar roles al abrir el modal
        $('#modalRoles').on('show.bs.modal', function() {
            $.get('roles.php?action=presentarRoles', function(data) {
                $('#contenedorRoles').html(`
                    <div class="table-responsive">
                        <table class="table table-hover">
                            ${data.listaRoles}
                        </table>
                    </div>
                `);
            }, 'json');
        });

        // 2. Delegar evento para abrir modal de permisos
        $(document).on('click', '.btn-rol-permisos', function() {
            const idrol = $(this).data('idrol');
            const nombreRol = $(this).data('nomrerol');
            
            $('#modalPermisosLabel').html(`Asignar permisos a: <strong>${nombreRol}</strong>`);
            $('#contenedorPermisos').html(`
                <div class="text-center my-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-2">Cargando permisos...</p>
                </div>
            `);
            
            $.post('permisos.php', { idrol: idrol }, function(html) {
                $('#contenedorPermisos').html(html);
            }, 'html');
            
            $('#modalRoles').modal('hide');
            $('#modalPermisos').modal('show');
        });

        // 3. Manejar el envío del formulario de permisos
        $(document).on('submit', '#formPermisos', function(e) {
            e.preventDefault();
            
            const formData = {
                action: 'guardar_permisos_rol',
                idrol: $(this).find('input[name="idrol"]').val(),
                permisos_menu: [],
                permisos_submenu: []
            };
            
            // Obtener menús completos seleccionados
            $('.menu-completo:checked').each(function() {
                formData.permisos_menu.push($(this).data('menu'));
            });
            
            // Obtener submenús seleccionados
            $('.submenu-permiso:checked:not(:disabled)').each(function() {
                formData.permisos_submenu.push($(this).val());
            });
            
            // Mostrar loading
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.prop('disabled', true).html(`
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Guardando...
            `);
            
            // Enviar datos
            $.ajax({
                url: 'guardar_permisos.php',
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Permisos actualizados',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#modalPermisos').modal('hide');
                    } else {
                        Swal.fire('Error', response.message || 'Error al guardar', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Error de conexión con el servidor', 'error');
                },
                complete: function() {
                    submitBtn.prop('disabled', false).text('Guardar Permisos');
                }
            });
        });
    });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</body>
</html>