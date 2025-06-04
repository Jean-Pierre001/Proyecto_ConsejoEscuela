<?php

// Mover carpeta a la papelera (folders)
if (isset($_POST['foldersToUndelete'])) {
  $foldersToUndelete = $_POST['foldersToUndelete'];
  $trashPath = "trash/$foldersToUndelete";
  $foldersPath = "folders/$foldersToUndelete";

  // Crear carpeta folders si no existe
  if (!is_dir('folders')) {
    mkdir('folders', 0777, true);
  }

  // Mover la carpeta a trash si existe
  if (is_dir($trashPath)) {
    rename($trashPath, $foldersPath,);
  }
}

// Función para eliminar carpeta y todo su contenido recursivamentes
function deleteFolder($folder) {
    if (!is_dir($folder)) {
        return false;
    }
    $files = array_diff(scandir($folder), array('.', '..'));
    foreach ($files as $file) {
        $path = "$folder/$file";
        if (is_dir($path)) {
            deleteFolder($path);
        } else {
            unlink($path);
        }
    }
    return rmdir($folder);
}

// Filtrado por nombre y localidad (debe ir antes del bloque que los usa)
$filterName = isset($_POST['filterName']) ? $_POST['filterName'] : '';
$filterLocalidad = isset($_POST['filterLocalidad']) ? $_POST['filterLocalidad'] : '';

// Eliminar filtros
if (isset($_POST['resetFilters'])) {
    $filterName = '';
    $filterLocalidad = '';
}

// Manejar el formulario para eliminar carpeta
if (isset($_POST['deleteTrash']) && isset($_POST['trashToDelete'])) {
    $trashToDelete = $_POST['trashToDelete'];
    $folderPath = "trash/$trashToDelete";

    if (is_dir($folderPath)) {
        if (deleteFolder($folderPath)) {
            echo "<div class='alert alert-success'>La carpeta '$trashToDelete' ha sido eliminada correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al eliminar la carpeta '$trashToDelete'.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>La carpeta '$trashToDelete' no existe.</div>";
    }
}

// Obtener las Carpetas
$trash = array_filter(scandir('trash'), fn($f) => $f != '.' && $f != '..');

// Filtrar las carpetas por nombre
if ($filterName !== '') {
    $trash = array_filter($trash, function ($t) use ($filterName) {
        return stripos($t, $filterName) === 0;
    });
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gestor de Papelera</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="trash.css" rel="stylesheet" />
</head>
<body>
  <header>
    <i class="bi bi-trash-fill me-2"></i>
    <h1>Papelera</h1>
  </header>

  <!-- Offcanvas Sidebar -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="demo" aria-labelledby="demoLabel">
    <div class="offcanvas-header flex-column align-items-center">
      <button type="button" class="btn-close text-reset mt-3" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
      <div class="w-100 text-center">
        <img src="img/consejologo.png" alt="Icono del Consejo" class="img-fluid" style="max-width: 50%;" />
      </div>
    </div>

    <div class="offcanvas-body">
      <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-house-door-fill"></i> Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="folders.php"><i class="bi bi-folder-fill"></i> Gestor de Carpetas</a></li>
        <li class="nav-item"><a class="nav-link" href="escuelas/escuelas.php"><i class="bi bi-building"></i> Gestor de Escuelas</a></li>
        <li class="nav-item"><a class="nav-link" href="inspectores/Inspectores.php"><i class="bi bi-person-badge-fill"></i> Gestor de Inspectores</a></li>
        <li class="nav-item"><a class="nav-link" href="usuarios/usuarios.php"><i class="bi bi-people-fill"></i> Gestor de Usuarios</a></li>
        <li class="nav-item"><a class="nav-link" href="trash.php"><i class="bi bi-trash-fill"></i> Papelera</a></li>
      </ul>
    </div>
  </div>

  <nav id="mainNavbar" class="navbar navbar-expand-lg sticky-top">
    <div class="container">
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
      <div class="section-title">🔍 Filtrar Papelera</div>
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
        </div>
        <button type="submit" class="btn btn-primary mt-3">Filtrar</button>
        <button type="submit" name="resetFilters" class="btn btn-secondary mt-3">Eliminar filtros</button>
      </form>
    </div>

    <div id="trashList">
      <?php
      if (empty($trash)) {
        echo "<div class='no-results'>Sin resultados</div>";
      } else {
        foreach ($trash as $t) {
          echo "
            <div class='trash-card mb-5'>
              <a href='trashDetails.php?trash=$t' class='text-decoration-none'>
                <i class='bi bi-trash-fill trash-icon'></i>
                <div class='trash-name'>$t</div>
              </a>
              <form method='POST' action='' onsubmit='return confirm(\"¿Estás seguro de que deseas eliminar esta carpeta?\")'>
                <input type='hidden' name='trashToDelete' value='$t'>
                <button type='submit' name='deleteTrash' class='btn btn-danger w-100 mt-3'>Eliminar Carpeta</button>
              </form>
              <form method='POST' action='' onsubmit='return confirm(\"¿Estás seguro de que deseas restaurar esta carpeta?\")'>
                <input type='hidden' name='foldersToUndelete' value='$t'>
                <button type='submit' name='undeleteFolders' class='btn btn-primary w-100 mt-3'>Restaurar Carpeta</button>
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
