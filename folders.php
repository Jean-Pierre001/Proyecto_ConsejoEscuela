<?php
// Crear carpeta
if (isset($_POST['createFolder'])) {
  $folderName = $_POST['folderName'];
  $folderDate = $_POST['folderDate'];

  $foldersEscuela = $_GET['CUE'];

  if (!file_exists("folders/$foldersEscuela/$folderName")) {
    mkdir("folders/$foldersEscuela/$folderName", 0777, true);
  }
}

// Eliminar carpeta
if (isset($_POST['deleteFolder'])) {
  $folderToDelete = $_POST['folderToDelete'];
  $folderPath = "folders/$folderToDelete";
  if (is_dir($folderPath)) {
    array_map('unlink', glob("$folderPath/*"));
    rmdir($folderPath);
  }
}

// Filtrado por nombre y fecha
$filterName = isset($_POST['filterName']) ? $_POST['filterName'] : '';
$filterDate = isset($_POST['filterDate']) ? $_POST['filterDate'] : '';

// Eliminar filtros
if (isset($_POST['resetFilters'])) {
  $filterName = '';
  $filterDate = '';
}

// Obtener las carpetas
$folders = array_filter(scandir('folders'), fn($f) => $f != '.' && $f != '..');

// Filtrar las carpetas por nombre
if ($filterName !== '') {
  $folders = array_filter($folders, function ($folder) use ($filterName) {
    return stripos($folder, $filterName) === 0; // Filtrar por letras iniciales
  });
}

// Filtrar las carpetas por fecha
if ($filterDate !== '') {
  $folders = array_filter($folders, function ($folder) use ($filterDate) {
    return date("Y-m-d", filemtime("folders/$folder")) === $filterDate;
  });
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestor de Carpetas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(180deg, #f5f7fa 0%, #c3cfe2 100%);
      font-family: 'Segoe UI', sans-serif;
    }
    header {
      background: linear-gradient(90deg, #4A90E2, #50A7F3);
      padding: 2.5px 0;
      color: white;
      text-align: center;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
    }
    .navbar {
      transition: all 0.3s ease;
      background-color: white;
      padding-top: 1rem;
      padding-bottom: 1rem;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .navbar.shrink {
      padding-top: 0.3rem;
      padding-bottom: 0.3rem;
    }

    .navbar-brand {
      font-weight: bold;
      font-size: 1.7rem;
      color: #1d3a8a;
    }

    .navbar-brand span {
      font-size: 0.7rem;
      background-color: #1d3a8a;
      color: white;
      padding: 2px 4px;
      border-radius: 3px;
      margin-right: 4px;
    }

    .nav-link {
      color: #1d3a8a !important;
      font-weight: 500;
    }
    .nav-item.dropdown:hover .nav-link {
      color: #f6b800 !important;
    }

    .dropdown-menu {
      border: none;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    header h1 {
      font-size: 2.5rem;
      font-weight: bold;
      margin-bottom: 10px;
    }
    header i {
      font-size: 2rem;
    }
    .card {
      border: none;
      border-radius: 20px;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.07);
    }
    .form-control {
      border-radius: 12px;
    }
    .btn-primary {
      border-radius: 12px;
      background-color: #4A90E2;
      border: none;
    }
    .btn-primary:hover {
      background-color: #357ABD;
    }
    .folder-card {
      background: #ffffff;
      border-radius: 16px;
      padding: 25px 15px;
      text-align: center;
      transition: all 0.3s ease;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
    }
    .folder-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }
    .folder-icon {
      font-size: 60px;
      color: #f7b731;
      margin-bottom: 10px;
    }
    .folder-name {
      font-size: 1.1rem;
      font-weight: 600;
      color: #333;
    }
    .text-muted {
      font-size: 0.9rem;
    }
    .section-title {
      font-weight: 600;
      font-size: 1.25rem;
      margin-bottom: 15px;
      color: #333;
    }
    .no-results {
      font-size: 1.2rem;
      color: #777;
      text-align: center;
      margin-top: 20px;
    }
    .btn-danger {
      background-color: #d9534f;
      border-radius: 12px;
    }
    .btn-danger:hover {
      background-color: #c9302c;
    }
  </style>
</head>
<body>
  <header>
    <i class="bi bi-folder-fill me-2"></i>
    <h1>Gestor de Carpetas</h1>
    <p class="lead">Organiza y visualiza tus carpetas y archivos fácilmente</p>
  </header>

  <!-- Navbar principal -->
  <nav id="mainNavbar" class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand" href="escuelas/escuelas.php">
        <span>Consejo</span>Escolar.
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="folders.php">Inicio</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container py-5">
    <div class="card mb-5 p-4">
      <div class="section-title">📁 Crear nueva carpeta</div>
      <form method="POST" action="">
        <div class="row g-3 align-items-center">
          <div class="col-md-5">
            <input type="text" name="folderName" class="form-control" placeholder="Nombre de la carpeta" required>
          </div> 
          <div class="col-md-3">
            <input type="date" name="folderDate" class="form-control">
          </div>
          <div class="col-md-2">
            <button type="submit" name="createFolder" class="btn btn-primary w-100">Crear</button>
          </div>
        </div>
      </form>
    </div>

    <div class="card mb-5 p-4">
      <div class="section-title">🔍 Filtrar carpetas</div>
      <form method="POST" action="">
        <div class="row g-3 align-items-center">
          <div class="col-md-6">
            <input type="text" name="filterName" class="form-control" placeholder="Filtrar por letra inicial..." value="<?php echo htmlspecialchars($filterName); ?>">
          </div>
          <div class="col-md-6">
            <input type="date" name="filterDate" class="form-control" value="<?php echo htmlspecialchars($filterDate); ?>">
          </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Filtrar</button>
        <button type="submit" name="resetFilters" class="btn btn-secondary mt-3">Eliminar filtros</button>
      </form>
    </div>

    <div class="row " id="folderList">
      <?php
        if (empty($folders)) {
          echo "<div class='no-results'>Sin resultados</div>";
        } else {
          foreach ($folders as $folder) {
            $folderDate = date("Y-m-d", filemtime("folders/$folder"));
            echo "
              <div class='col-sm-6 col-md-4 col-lg-3 mb-4 folder-card '>
                <div class='folder-card'>
                  <a href='folderDetails.php?folder=$folder' class='text-decoration-none'>
                    <i class='bi bi-folder-fill folder-icon'></i>
                    <div class='folder-name'>$folder</div>
                  </a>
                  <div class='text-muted'>$folderDate</div>
                  <form method='POST' action='' onsubmit='return confirm(\"¿Estás seguro de que deseas eliminar esta carpeta?\")'>
                    <input type='hidden' name='folderToDelete' value='$folder'>
                    <button type='submit' name='deleteFolder' class='btn btn-danger w-100 mt-3'>Eliminar carpeta</button>
                  </form>
                </div>
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
