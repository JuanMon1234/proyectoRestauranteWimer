<?php
session_start();
if (!isset($_SESSION['Idrol']) || $_SESSION['Idrol'] != 2) {
    header("Location: index.php?k=4"); // Solo accesible para chefs
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Receta</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4">Nueva Receta</h2>

  <form action="guardar_receta.php" method="POST">
    <div class="mb-3">
      <label for="nombre_plato" class="form-label">Nombre del Plato</label>
      <input type="text" class="form-control" id="nombre" name="nombre" required>
    </div>

    <div class="mb-3">
      <label for="tipo_plato" class="form-label">Tipo de Plato</label>
      <input type="text" class="form-control" id="tipo_plato" name="tipo_plato">
    </div>

    <div class="mb-3">
      <label for="ingrediente_principal" class="form-label">Ingrediente Principal</label>
      <input type="text" class="form-control" id="ingrediente_principal" name="ingrediente_principal">
    </div>

    <div class="mb-3">
      <label for="precio" class="form-label">Precio estimado (COP)</label>
      <input type="number" class="form-control" id="precio" name="precio" step="100" required>
    </div>

    <div class="mb-3">
      <label for="comentario" class="form-label">Comentario personal (opcional)</label>
      <textarea class="form-control" id="comentario" name="comentario" rows="3"></textarea>
    </div>
    <div class="mb-3">
      <label for="fuente" class="form-label">fuente (recetaabuela/youtube/etc.)</label>
      <input type="text" class="form-control" id="fuente" name="fuente">
    </div>


    <div class="mb-3">
      <label for="ubicacion" class="form-label">Ubicación física (estantería/libro/etc.)</label>
      <input type="text" class="form-control" id="ubicacion" name="ubicacion">
    </div>
    
    <div class="mb-3">
      <label for="tiempo_total" class="form-label">Tiempo total estimado (minutos)</label>
      <input type="number" class="form-control" id="tiempo_total" name="tiempo_total" required>
    </div>


    <button type="submit" class="btn btn-primary">Guardar Receta</button>
  </form>
</div>

</body>
</html>
