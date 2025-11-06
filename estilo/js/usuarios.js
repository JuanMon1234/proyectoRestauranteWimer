$(document).ready(function() {
    // Inicializar DataTable
    let table = $('#tablaUsuarios').DataTable({
        orderCellsTop: true,
        fixedHeader: true
    });

    // ---------------------------
    // ELIMINAR USUARIO
    // ---------------------------
    $(document).on('click', '.btn-eliminar', function() {
        let btn = $(this);
        let id = btn.data('id');

        if (confirm("¿Seguro que deseas eliminar este usuario?")) {
            $.post('eliminar.php', { id: id }, function(response) {
                try {
                    let res = typeof response === "string" ? JSON.parse(response) : response;
                    if (res.status === "success") {
                        table.row(btn.closest('tr')).remove().draw();
                        alert(res.message);
                    } else {
                        alert(res.message);
                    }
                } catch (e) {
                    console.error("Respuesta inesperada:", response);
                }
            });
        }
    });

    // ---------------------------
    // ABRIR MODAL AGREGAR
    // ---------------------------
    $(document).on('click', '.btn-agregar', function() {
        $('#modalAgregar').modal('show');
        $('#contenidoModalAgregar').html('<div class="text-center p-5">Cargando...</div>');
        $('#contenidoModalAgregar').load('agregarus.php', function(response, status) {
            if (status === "error") {
                $('#contenidoModalAgregar').html('<p class="text-danger p-3">Error al cargar el formulario</p>');
            }
        });
    });

    // ---------------------------
    // ABRIR MODAL EDITAR
    // ---------------------------
    $(document).on('click', '.btn-editar', function() {
        let id = $(this).data('id');
        $('#modalEditar').modal('show');
        $('#contenidoModalEditar').html('<div class="text-center p-5">Cargando...</div>');
        $('#contenidoModalEditar').load('editar.php?id=' + id, function(response, status) {
            if (status === "error") {
                $('#contenidoModalEditar').html('<p class="text-danger p-3">Error al cargar el formulario</p>');
            }
        });
    });

    // ---------------------------
    // GUARDAR FORMULARIO AGREGAR vía AJAX
    // ---------------------------
    $(document).on('submit', '#formAgregarUsuario', function(e){
        e.preventDefault();
        let formData = $(this).serialize();

        $.post('agregarus.php', formData, function(response){
            $('#contenidoModalAgregar').html(response);
            setTimeout(() => {
                $('#modalAgregar').modal('hide');
                location.reload();
            }, 1500);
        });
    });

    // ---------------------------
    // GUARDAR FORMULARIO EDITAR vía AJAX
    // ---------------------------
    $(document).on('submit', '#formEditarUsuario', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        let id = $('input[name="id"]').val(); // obtiene el id del input hidden

        $.post('editar.php?id=' + id, formData, function(response) {
            $('#contenidoModalEditar').html(response);
            setTimeout(() => {
                $('#modalEditar').modal('hide');
                location.reload(); // recargar tabla
            }, 1500);
        });
    });

    // ---------------------------
    // CAMBIAR ESTADO USUARIO
    // ---------------------------
    $(document).on('change', '.cambiar-estado', function() {
        let select = $(this);
        let id = select.data('id');
        let estado = select.val();

        $.post('cambiar_estado.php', { id: id, estado: estado }, function(response) {
            try {
                let res = typeof response === "string" ? JSON.parse(response) : response;
                alert(res.message);
            } catch(e) {
                console.error("Respuesta inesperada:", response);
            }
        });
    });
});
