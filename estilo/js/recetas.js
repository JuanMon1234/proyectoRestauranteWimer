$(document).ready(function() {
    $('#tablaRecetas').DataTable();

    // Abrir modal Agregar
    $('#btnAgregarReceta').click(function() {
        $('#contenidoModalAgregarReceta').load('form_agregar_receta.php', function() {
            $('#modalAgregarReceta').modal('show');
        });
    });

    // Abrir modal Editar
    $(document).on('click', '.btn-editar', function() {
        const id = $(this).data('id');
        $('#contenidoModalEditarReceta').load('form_editar_receta.php?id=' + id, function() {
            $('#modalEditarReceta').modal('show');
        });
    });

    // Guardar nueva receta vía AJAX
    $(document).on('submit', '#formAgregarReceta', function(e) {
        e.preventDefault();
        const data = $(this).serialize();
        $.post('recetas_acciones.php', data + '&action=agregar', function(resp) {
            if (resp.success) {
                $('#modalAgregarReceta').modal('hide');
                location.reload();
            } else {
                alert(resp.message);
            }
        }, 'json');
    });

    // Guardar edición de receta
    $(document).on('submit', '#formEditarReceta', function(e) {
        e.preventDefault();
        const data = $(this).serialize();
        $.post('recetas_acciones.php', data + '&action=editar', function(resp) {
            if (resp.success) {
                $('#modalEditarReceta').modal('hide');
                location.reload();
            } else {
                alert(resp.message);
            }
        }, 'json');
    });

    // Eliminar receta
    $(document).on('click', '.btn-eliminar', function() {
        const id = $(this).data('id');
        if (confirm('¿Deseas eliminar esta receta?')) {
            $.post('recetas_acciones.php', { action: 'eliminar', id: id }, function(resp) {
                if (resp.success) {
                    alert('Receta eliminada');
                    location.reload();
                } else {
                    alert(resp.message);
                }
            }, 'json');
        }
    });
});
