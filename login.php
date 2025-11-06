<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Restaurante</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  
  <!-- Ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <link href="estilo/css/login.css" rel="stylesheet">
  

</head>

<body class="bg-white">
  <div class="container login-container">
    <div class="card login-card shadow">
      <div class="card-header login-header py-3">
        <h3 class="text-center mb-0">Inicio de Sesión</h3>
      </div>
      
      <div class="card-body p-4">
        <div class="mb-3">
          <label for="correo_login" class="form-label">Correo electrónico</label>
          <input type="email" id="correo_login" class="form-control" placeholder="Ingrese su correo" autocomplete="off">
        </div>
        
        <div class="mb-3">
          <label for="clave_login" class="form-label">Contraseña</label>
          <input type="password" id="clave_login" class="form-control" placeholder="Ingrese su contraseña" autocomplete="off">
        </div>
        
        <div class="mb-3">
          <label for="rol_login" class="form-label">Rol</label>
          <select id="rol_login" class="form-select">
            <option value="" disabled selected>Seleccione su rol</option>
          </select>
        </div>

        <button type="submit" id="btn_ingresar" class="btn btn-login text-white w-100 mb-2 py-2">Ingresar</button>

        <button type="button" class="btn btn-outline-secondary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#registroModal">
          Registrarse
        </button>
        <button type="button" class="btn btn-link w-100 text-decoration-none" id="btn_recuperar">¿Olvidó su contraseña?</button>

        <div id="mensaje_login" class="alert alert-danger mt-3 mb-0 d-none"></div>
      </div>
    </div>
  </div>

  <!-- Modal de Registro -->
  <div class="modal fade" id="registroModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Registro de Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" id="nombre" class="form-control" placeholder="Nombre">
            </div>
            <div class="col-md-6">
              <label for="apellido" class="form-label">Apellido</label>
              <input type="text" id="apellido" class="form-control" placeholder="Apellido">
            </div>
            
            <div class="col-12">
              <label for="rol_registro" class="form-label">Rol</label>
              <select id="rol_registro" class="form-select">
                <option value="" disabled selected>Seleccione Rol</option>
                
              </select>
            </div>
            
            <div class="col-md-6">
              <label for="selectTipoDoc" class="form-label">Tipo de Documento</label>
              <select id="selectTipoDoc" class="form-select"></select>
            </div>
            <div class="col-md-6">
              <label for="identificacion" class="form-label">Identificación</label>
              <input type="text" id="identificacion" class="form-control" placeholder="Identificación">
            </div>
            
            <div class="col-12">
              <label for="telefono" class="form-label">Celular</label>
              <input type="tel" id="telefono" class="form-control" placeholder="Celular">
            </div>
            
            <div class="col-12">
              <label for="correo_registro" class="form-label">Correo electrónico</label>
              <input type="email" id="correo_registro" class="form-control" placeholder="Correo">
            </div>
            
            <div class="col-12">
              <label for="clave_registro" class="form-label">Contraseña</label>
              <input type="password" id="clave_registro" class="form-control" placeholder="Contraseña">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" id="btn_guardar" class="btn btn-primary">Registrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="estilo/js/app.js"></script>
    <script src="estilo/js/login.js"></script>

</body>
</html>