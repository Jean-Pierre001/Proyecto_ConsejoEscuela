<?php
// Obtener la carpeta actual (incluyendo subcarpetas si las hay)
$folderName = isset($_GET['folder']) ? $_GET['folder'] : '';
$folderPath = "folders/$folderName";

// Verificar si la carpeta existe
if (!is_dir($folderPath)) {
  die("La carpeta no existe.");
}

// Función para eliminar archivos y subcarpetas recursivamente
function deleteFolderAndContents($dirPath) {
  if (!is_dir($dirPath)) return;
  $files = array_diff(scandir($dirPath), array('.', '..'));
  foreach ($files as $file) {
    $filePath = $dirPath . DIRECTORY_SEPARATOR . $file;
    if (is_dir($filePath)) {
      deleteFolderAndContents($filePath);
      rmdir($filePath);
    } else {
      unlink($filePath);
    }
  }
  rmdir($dirPath);
}

// Subir archivo
if (isset($_POST['uploadFile'])) {
  $targetDir = "$folderPath/";
  $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  if (file_exists($targetFile)) {
    echo "El archivo ya existe.";
    $uploadOk = 0;
  }
  if ($_FILES["fileToUpload"]["size"] > 10000000) {
    echo "El archivo es demasiado grande.";
    $uploadOk = 0;
  }
  if (!in_array($fileType, ['jpg', 'png', 'jpeg', 'gif', 'pdf', 'txt', 'docx'])) {
    echo "Solo se permiten archivos JPG, PNG, JPEG, GIF, PDF, TXT o DOCX.";
    $uploadOk = 0;
  }

  if ($uploadOk == 0) {
    echo "El archivo no se pudo subir.";
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
      echo "El archivo ". basename($_FILES["fileToUpload"]["name"]). " ha sido subido.";
    } else {
      echo "Hubo un error al subir el archivo.";
    }
  }
}

// Crear subcarpeta
if (isset($_POST['createFolder'])) {
  $newFolder = $_POST['newFolderName'];
  $newFolderPath = "$folderPath/$newFolder";
  if (!is_dir($newFolderPath)) {
    mkdir($newFolderPath, 0777, true);
    echo "Subcarpeta '$newFolder' creada con éxito.";
  } else {
    echo "La subcarpeta ya existe.";
  }
}

// Eliminar archivo
if (isset($_GET['deleteFile'])) {
  $fileToDelete = $_GET['deleteFile'];
  $filePathToDelete = "$folderPath/$fileToDelete";
  if (file_exists($filePathToDelete)) {
    unlink($filePathToDelete);
    echo "El archivo '$fileToDelete' ha sido eliminado.";
  } else {
    echo "El archivo no existe.";
  }
}

// Eliminar subcarpeta
if (isset($_GET['deleteFolder'])) {
  $folderToDelete = $_GET['deleteFolder'];
  $folderPathToDelete = "$folderPath/$folderToDelete";
  if (is_dir($folderPathToDelete)) {
    deleteFolderAndContents($folderPathToDelete);
    echo "La subcarpeta '$folderToDelete' ha sido eliminada.";
  } else {
    echo "La subcarpeta no existe.";
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalles de la Carpeta - <?php echo htmlspecialchars($folderName); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(180deg, #f5f7fa 0%, #c3cfe2 100%);
      font-family: 'Segoe UI', sans-serif;
    }
    header {
      background: linear-gradient(90deg, #4A90E2, #50A7F3);
      padding: 2.5% 0;
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
      font-size: 0.9rem;
      background-color: #1d3a8a;
      color: white;
      padding: 6px 6px;
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
      font-size: 2.0rem;
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
  <h1>Detalles de la Carpeta: <?php echo htmlspecialchars($folderName); ?></h1>
</header>

<!-- Navbar principal -->
<nav id="mainNavbar" class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand" href="index.php">
      <span class="bi bi-house-door-fill"> Consejo Escolar </span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="escuelas/escuelas.php">Escuelas</a></li>
        </ul>
      </div>
    </div>
  </nav>

<div class="container py-5">

  <div class="card p-4 mb-5">
    <h2>Subir un archivo</h2>
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="fileToUpload" class="form-label">Seleccionar archivo</label>
        <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" required>
      </div>
      <button type="submit" name="uploadFile" class="btn btn-primary btn-upload">Subir archivo</button>
    </form>
  </div>

  <div class="card p-4 mb-5">
    <h2>Crear subcarpeta</h2>
    <form action="" method="POST">
      <div class="mb-3">
        <label for="newFolderName" class="form-label">Nombre de la subcarpeta</label>
        <input type="text" name="newFolderName" id="newFolderName" class="form-control" required>
      </div>
      <button type="submit" name="createFolder" class="btn btn-success btn-create-folder">Crear subcarpeta</button>
    </form>
  </div>

  <div class="card p-4">
    <h3>Contenido</h3>
    <div class="file-list">
      <?php
        $items = array_diff(scandir($folderPath), array('.', '..'));
        foreach ($items as $item) {
          $itemPath = "$folderPath/$item";
          $itemUrl = urlencode(trim($folderName === '' ? $item : "$folderName/$item"));
          if (is_dir($itemPath)) {
            echo "<div class='folder-item'>
                    <a href='?folder=$itemUrl'><strong>📁 $item</strong></a>
                    <div>
                      <a href='?folder=" . urlencode($folderName) . "&deleteFolder=" . urlencode($item) . "' class='btn btn-sm btn-outline-danger btn-delete'>Eliminar</a>
                    </div>
                  </div>";
          } else {
            echo "<div class='file-item'>
                    <a href='$itemPath' download>$item</a>
                    <div>
                      <a href='?folder=" . urlencode($folderName) . "&deleteFile=" . urlencode($item) . "' class='btn btn-sm btn-outline-danger btn-delete'>Eliminar</a>
                    </div>
                  </div>";
          }
        }
      ?>
    </div>
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
