<?php
require_once "../../include/config.php" ;
require_once "../../include/conex.php" ;
require_once "../../include/funciones.php";

$id = intval($_GET['id']);
$receta = ejecutarConsultaSegura("SELECT * FROM recetas WHERE id_receta = $id");
$receta = mysqli_fetch_assoc($receta);

// Traer lista de platos para el select
$platos = ejecutarConsultaSegura("SELECT id_plato, nombre FROM platos");
?>
<div class="modal-header bg-warning text-dark">
    <h5 class="modal-title">Editar Receta</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
</div>
<div class="modal-body">
    <form id="formEditarReceta">
        <input type="hidden" name="id_receta" value="<?= $receta['id_receta'] ?>">
        <div class="mb-3">
            <label for="id_plato" class="form-label">Plato</label>
            <select name="id_plato" id="id_plato" class="form-select" required>
                <?php while($p = mysqli_fetch_assoc($platos)): ?>
                    <option value="<?= $p['id_plato'] ?>" <?= $receta['id_plato'] == $p['id_plato'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($p['nombre']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="tiempo_total" class="form-label">Tiempo Total</label>
            <input type="text" class="form-control" name="tiempo_total" value="<?= htmlspecialchars($receta['tiempo_total']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="fuente" class="form-label">Fuente</label>
            <input type="text" class="form-control" name="fuente" value="<?= htmlspecialchars($receta['fuente']) ?>">
        </div>
        <div class="mb-3">
            <label for="ubicacion_fisica" class="form-label">Ubicación Física</label>
            <input type="text" class="form-control" name="ubicacion_fisica" value="<?= htmlspecialchars($receta['ubicacion_fisica']) ?>">
        </div>
        <div class="mb-3">
            <label for="tipo_plato" class="form-label">Tipo de Plato</label>
            <input type="text" class="form-control" name="tipo_plato" value="<?= htmlspecialchars($receta['tipo_plato']) ?>">
        </div>
        <div class="mb-3">
            <label for="ingrediente_principal" class="form-label">Ingrediente Principal</label>
            <input type="text" class="form-control" name="ingrediente_principal" value="<?= htmlspecialchars($receta['ingrediente_principal']) ?>">
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" class="form-control" name="precio" value="<?= htmlspecialchars($receta['precio']) ?>" step="0.01">
        </div>
        <div class="mb-3">
            <label for="comentario_personal" class="form-label">Comentario Personal</label>
            <textarea class="form-control" name="comentario_personal" rows="3"><?= htmlspecialchars($receta['comentario_personal']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-warning">Actualizar Receta</button>
    </form>
</div>

<script>
$('#formEditarReceta').submit(function(e){
    e.preventDefault();
    let data = $(this).serialize();
    $.post('actualizar_receta.php', data, function(res){
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
