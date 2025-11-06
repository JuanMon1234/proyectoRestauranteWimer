console.log("✅ login.js cargado correctamente");

$(document).ready(function () {

    // 🔄 Cargar tipos de documento
    $.post("include/ctrlLogin.php", { action: 'selectTipoD' }, function (data) {
        $("#selectTipoDoc").html(data.optionTipoDocumento);
    }, 'json');

    // 🔄 Cargar roles dinámicamente
    $.post("include/ctrlLogin.php", { action: 'selectRoles' }, function (data) {
        $("#rol_login").html(data.optionRoles);       // Para login
        $("#rol_registro").html(data.optionRoles);    // Para registro
    }, 'json');

    // 🔐 Iniciar sesión
    $("#btn_ingresar").on("click", function (event) {
        event.preventDefault();
        console.log("🟢 Click detectado, enviando AJAX...");

        const correo = $.trim($("#correo_login").val());
        const clave = $.trim($("#clave_login").val());
        const rol = $("#rol_login").val();

        // Validación
        if (!correo || !clave || !rol) {
            showMessage("Todos los campos son obligatorios.");
            return;
        }

        // Validar formato email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(correo)) {
            showMessage("Por favor ingrese un correo electrónico válido.");
            return;
        }

        // Enviar solicitud al servidor
        $.post("include/ctrlLogin.php", {
            action: 'iniciar',
            correo: correo,
            clave: clave,
            rol: rol
        }, function (data) {
            console.log('Respuesta servidor:', data);
            if (data.rspst === "1") {
                console.log("✔️ Login exitoso, redirigiendo...");
    switch (rol) {
        case "1":
            window.location.href = "archivos/vista/admin.php";
            break;
        case "2":
            window.location.href = "archivos/vista/chef.php";
            break;
        case "3":
            window.location.href = "archivos/vista/mesero.php";
            break;
        case "4":
            window.location.href = "archivos/vista/cajero.php";
            break;
        case "5":
            window.location.href = "archivos/vista/cliente.php";
            break;
        default:
            window.location.href = "archivos/vista/inicio.php";
    }
    } else {
                showMessage(data.msj);
            }
        }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
        console.error("❌ Error AJAX:", textStatus, errorThrown, jqXHR.responseText);
        showMessage("Error de conexión al servidor.");
    });
    });

    // 📝 Registrar usuario
    $("#btn_guardar").on("click", function () {
        const formData = {
            nombre: $('#nombre').val(),
            apellido: $('#apellido').val(),
            rol: $('#rol_registro').val(),
            identificacion: $('#identificacion').val(),
            idTipoDocumento: $('#selectTipoDoc').val(),
            telefono: $('#telefono').val(),
            correoregistro: $('#correo_registro').val(),
            claveregistro: $('#clave_registro').val()
        };

        // Validación
        let isValid = true;
        Object.keys(formData).forEach(key => {
            if (!formData[key]) {
                isValid = false;
            }
        });

        if (!isValid) {
            showModalMessage("Todos los campos son obligatorios.");
            return;
        }

        // Validación de cédula
        const cedulaRegex = /^[0-9]{6,12}$/;
        if (!cedulaRegex.test(formData.identificacion)) {
            showModalMessage("Por favor ingrese una cédula válida (solo números, 6-12 dígitos).");
            return;
        }

        // Loader
        $("#btn_guardar").prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Verificando...');

        // Verificar si la cédula ya está registrada
        $.post("include/ctrlLogin.php", {
            action: 'verificarCedula',
            identificacion: formData.identificacion
        }, function (response) {
            if (response.existe) {
                showModalMessage("La cédula ingresada ya está registrada en el sistema.");
                $("#btn_guardar").prop('disabled', false).text("Registrar");
                return;
            }

            // Proceder con el registro
            $.post("include/ctrlLogin.php", {
                action: 'registrarUsuario',
                ...formData
            }, function (data) {
                $("#btn_guardar").prop('disabled', false).text("Registrar");

                if (data.rspst === "1") {
                    const correo = formData.correoregistro;
                    $("#registroModal input").val('');
                    $("#registroModal select").val('');
                    $("#registroModal").modal('hide');

                    if (correo) {
                        $.post("herramientas/llave/registllave.php", {
                            correo: correo
                        }, function (data) {
                            showMessage(data.msjValidez, 'success');
                        }, 'json');
                    } else {
                        showMessage("Usuario registrado exitosamente.", 'success');
                    }

                } else {
                    showModalMessage(data.msj);
                }
            }, 'json');

        }, 'json');
    });

    // 🔓 Recuperar contraseña
    $("#btn_recuperar").on("click", function () {
        const correo = $("#correo_login").val();
        if (!correo) {
            showMessage("Ingrese su correo para recuperar la contraseña.");
            return;
        }

        $.post("herramientas/llave/ctrllave.php", {
            correoinicio: correo
        }, function (data) {
            showMessage(data.msjValidez, data.rspst === "1" ? 'success' : 'danger');
        }, 'json');
    });

    // 📢 Mensaje en pantalla principal (login)
    function showMessage(text, type = 'danger') {
        const $msg = $("#mensaje_login");
        $msg.removeClass('d-none alert-success alert-danger')
            .addClass(`alert-${type}`)
            .text(text)
            .show();
        if (type === 'success') {
            setTimeout(() => $msg.fadeOut(), 3000);
        }
    }

    // 📢 Mensaje en modal (registro)
    function showModalMessage(text, type = 'danger') {
        let $modalMsg = $('#mensaje_registro');
        if (!$modalMsg.length) {
            $modalMsg = $('<div id="mensaje_registro" class="alert mb-3"></div>');
            $('.modal-body').prepend($modalMsg);
        }

        $modalMsg.removeClass('alert-danger alert-success alert-warning')
                .addClass(`alert-${type}`)
                .text(text)
                .removeClass('d-none');

        if (type === 'success') {
            setTimeout(() => $modalMsg.fadeOut(), 5000);
        }
    }
});
$(document).ready(function () {

    // TOGGLE SIDEBAR
    $('#sidebarToggle').click(function () {
        $('.sidebar').toggleClass('active');
    });

    // DATATABLE USUARIOS
    if ($('#tablaUsuarios').length) {
        $('#tablaUsuarios').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
            },
            columnDefs: [{ orderable: false, targets: [6] }]
        });
    }

    

});
