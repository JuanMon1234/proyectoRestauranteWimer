$(document).ready(function () {
    const sidebar = $('.sidebar');
    const overlay = $('#sidebarOverlay');

    // TOGGLE SIDEBAR
    $('#sidebarToggle').click(function () {
        sidebar.toggleClass('show');
        overlay.toggle();
    });

    overlay.click(function () {
        sidebar.removeClass('show');
        overlay.hide();
    });

    $(window).on('resize', function () {
        if ($(window).width() > 768) {
            sidebar.addClass('show');
            overlay.hide();
        }
    }).trigger('resize');

    // DATATABLE USUARIOS
    if ($('#tablaUsuarios').length) {
        $('#tablaUsuarios').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
            },
            columnDefs: [{ orderable: false, targets: [6] }]
        });
    }

    // CERRAR SESIÓN con confirmación
    $("#navBtnSalir").click(function () {
        Swal.fire({
            title: '¿Seguro que quieres cerrar sesión?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, salir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("../../include/ctrlLogin.php", { action: 'salir' }, function (data) {
                    if (data.rspst === "1") {
                        location.href = "../../login.php";
                    } else {
                        Swal.fire('Error', 'No se pudo cerrar sesión', 'error');
                    }
                }, "json");
            }
        });
    });
});
