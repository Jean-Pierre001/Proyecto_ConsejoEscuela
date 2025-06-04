<?php
require_once 'baseDatos/conexion.php';

// Mover carpeta a la papelera (trash)
if (isset($_POST['moveFolder'])) {
  $folderToDelete = $_POST['folderToDelete'];
  $folderPath = "folders/$folderToDelete";
  $trashPath = "trash/$folderToDelete";

  if (!is_dir('trash')) {
    mkdir('trash', 0777, true);
  }

  if (is_dir($folderPath)) {
    rename($folderPath, $trashPath);
  }
}

// Filtrado
$filterName = $_POST['filterName'] ?? '';
$filterLocalidad = $_POST['filterLocalidad'] ?? '';

if (isset($_POST['resetFilters'])) {
  $filterName = '';
  $filterLocalidad = '';
}

// Consulta a la base de datos
$query = "SELECT nombre, localidad FROM carpetas WHERE 1=1";
$params = [];

if ($filterName !== '') {
  $query .= " AND nombre LIKE :nombre";
  $params[':nombre'] = "$filterName%";
}

if ($filterLocalidad !== '') {
  $query .= " AND localidad LIKE :localidad";
  $params[':localidad'] = "%$filterLocalidad%";
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$folders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gestor de Carpetas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="folders.css" rel="stylesheet" />
</head>
<body>

<header class="text-white bg-primary p-4 text-center">
  <i class="bi bi-folder-fill me-2"></i>
  <h1>Gestor de Carpetas</h1>
</header>

  <!-- Offcanvas Sidebar -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="demo" aria-labelledby="demoLabel">
    <!-- Encabezado con imagen centrada -->
    <div class="offcanvas-header flex-column align-items-center">
      <button type="button" class="btn-close text-reset mt-3" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
      <div class="w-100 text-center">
        <img src="img/consejologo.png" alt="Icono del Consejo" class="img-fluid" style="max-width: 50%;" />
      </div>
    </div>

    <!-- Cuerpo con menú de navegación -->
    <div class="offcanvas-body">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link" href="index.php"><i class="bi bi-house-door-fill"></i> Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="folders.php"><i class="bi bi-folder-fill"></i> Gestor de Carpetas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="escuelas/escuelas.php"><i class="bi bi-building"></i> Gestor de Escuelas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="inspectores/inspectores.php"><i class="bi bi-person-badge-fill"></i> Gestor de Inspectores</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="usuarios/usuarios.php"><i class="bi bi-people-fill"></i> Gestor de Usuarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="trash.php"><i class="bi bi-trash-fill"></i> Papelera</a>
        </li>
      </ul>
    </div>
  </div>

  <!-- Navbar principal -->
  <nav id="mainNavbar" class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <!-- Botón para abrir el sidebar -->
      <button class="btn btn-primary m-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#demo" aria-controls="demo">
        <i class="bi bi-list"></i> Consejo Escolar
      </button>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>

  <div class="container py-5">
    <div class="card mb-5 p-4">
      <div class="section-title">🔍 Filtrar carpetas</div>
      <form method="POST" action="">
        <div class="row g-3 align-items-center">
          <div class="col-md-6">
            <input
              type="text"
              name="filterName"
              class="form-control"
              placeholder="Filtrar por letra inicial..."
              value="<?php echo htmlspecialchars($filterName); ?>"
            />
          </div>
          <div class="col-md-6">
            <input
              type="text"
              name="filterLocalidad"
              class="form-control"
              placeholder="Filtrar por localidad..."
              value="<?php echo htmlspecialchars($filterLocalidad); ?>"
            />
          </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Filtrar</button>
        <button type="submit" name="resetFilters" class="btn btn-secondary mt-3">Eliminar filtros</button>
      </form>
    </div>

    <div id="folderList">
      <?php
      if (empty($folders)) {
        echo "<div class='no-results'>Sin resultados</div>";
      } else {
        foreach ($folders as $folder) {
  $nombre = htmlspecialchars($folder['nombre']);
  $localidad = htmlspecialchars($folder['localidad']);

  echo "
    <div class='folder-card mb-5'>
      <a href='folderDetails.php?folder=$nombre' class='text-decoration-none'>
        <i class='bi bi-folder-fill folder-icon'></i>
        <div class='folder-name'>$nombre</div>
      </a>
      <div class='text-muted'>Localidad: $localidad</div>
      <form method='POST' action='' onsubmit='return confirm(\"¿Estás seguro de que deseas eliminar esta carpeta?\")'>
        <input type='hidden' name='folderToDelete' value='$nombre'>
        <button type='submit' name='moveFolder' class='btn btn-danger w-100 mt-3'>Mover a papelera</button>
      </form>
    </div>
  ";
}

      }
      ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    const navbar = document.getElementById('mainNavbar');
    window.addEventListener('scroll', function () {
      if (window.scrollY > 50) {
        navbar.classList.add('shrink');
      } else {
        navbar.classList.remove('shrink');
      }
    });
  </script>
</body>
</html>
