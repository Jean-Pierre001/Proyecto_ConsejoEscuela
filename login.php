<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Offcanvas Sidebar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="index.css" rel="stylesheet">
</head>
<body>

<!-- Botón para abrir el sidebar -->
<button class="btn btn-primary m-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#demo" aria-controls="demo">
  <i class="bi bi-list"></i> Consejo Escolar
</button>

<!-- Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="demo" aria-labelledby="demoLabel">
  
  <!-- Encabezado con imagen centrada -->
  <div class="offcanvas-header flex-column align-items-center">
    <button type="button" class="btn-close text-reset mt-3" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    <div class="w-100 text-center">
      <img src="img/consejologo.png" alt="Icono del Consejo" class="img-fluid" style="max-width: 50%;">
    </div>
  </div>

  <!-- Cuerpo con menú de navegación -->
  <div class="offcanvas-body">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link" href="index.php"><i class="bi bi-house-door-fill"></i> Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php"><i class="bi bi-folder-fill"></i> Gestor de Carpetas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php"><i class="bi bi-building"></i> Gestor de Escuelas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php"><i class="bi bi-person-badge-fill"></i> Gestor de Inspectores</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php"><i class="bi bi-people-fill"></i> Gestor de Usuarios</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php"><i class="bi bi-trash-fill"></i> Papelera</a>
      </li>
    </ul>
  </div>
</div>

<!-- Bootstrap JS (con Popper incluido) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
