<?php
require_once "../../include/config.php";
require_once "../../include/conex.php";
require_once "../../include/funciones.php";

// Traer lista de platos para el select
$platos = ejecutarConsultaSegura("SELECT id_plato, nombre FROM platos");
?>
<div class="modal-header bg-success text-white">
    <h5 class="modal-title">Agregar Receta</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
</div>
<div class="modal-body">
    <form id="formAgregarReceta">
        <div class="mb-3">
            <label for="id_plato" class="form-label">Plato</label>
            <select name="id_plato" id="id_plato" class="form-select" required>
                <option value="">Seleccione un plato</option>
                <?php while($p = mysqli_fetch_assoc($platos)): ?>
                    <option value="<?= $p['id_plato'] ?>"><?= htmlspecialchars($p['nombre']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="tiempo_total" class="form-label">Tiempo Total</label>
            <input type="text" class="form-control" name="tiempo_total" id="tiempo_total" required>
        </div>
        <div class="mb-3">
            <label for="fuente" class="form-label">Fuente</label>
            <input type="text" class="form-control" name="fuente" id="fuente">
        </div>
        <div class="mb-3">
            <label for="ubicacion_fisica" class="form-label">Ubicación Física</label>
            <input type="text" class="form-control" name="ubicacion_fisica" id="ubicacion_fisica">
        </div>
        <div class="mb-3">
            <label for="tipo_plato" class="form-label">Tipo de Plato</label>
            <input type="text" class="form-control" name="tipo_plato" id="tipo_plato">
        </div>
        <div class="mb-3">
            <label for="ingrediente_principal" class="form-label">Ingrediente Principal</label>
            <input type="text" class="form-control" name="ingrediente_principal" id="ingrediente_principal">
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" class="form-control" name="precio" id="precio" step="0.01">
        </div>
        <div class="mb-3">
            <label for="comentario_personal" class="form-label">Comentario Personal</label>
            <textarea class="form-control" name="comentario_personal" id="comentario_personal" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Guardar Receta</button>
    </form>
</div>

<script>
$('#formAgregarReceta').submit(function(e){
    e.preventDefault();
    let data = $(this).serialize();
    $.post('guardar_receta.php', data, function(res){
        if(res.status == 'success'){
            Swal.fire('Éxito', res.message, 'success').then(()=>{
                location.reload();
            });
        } else {
            Swal.fire('Error', res.message, 'error');
        }
    }, 'json');
});
</script>
