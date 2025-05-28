<?php
// Obtener la carpeta actual (incluyendo subcarpetas si las hay)
$trashName = isset($_GET['trash']) ? $_GET['trash'] : '';
$trashPath = "trash/$trashName";

// Verificar si la carpeta existe
if (!is_dir($trashPath)) {
  die("La carpeta no existe.");
}

// Función para eliminar archivos y subcarpetas recursivamente
function deletetrashAndContents($dirPath) {
  if (!is_dir($dirPath)) return;
  $files = array_diff(scandir($dirPath), array('.', '..'));
  foreach ($files as $file) {
    $filePath = $dirPath . DIRECTORY_SEPARATOR . $file;
    if (is_dir($filePath)) {
      deletetrashAndContents($filePath);
      rmdir($filePath);
    } else {
      unlink($filePath);
    }
  }
  rmdir($dirPath);
}

// Subir archivo
if (isset($_POST['uploadFile'])) {
  $targetDir = "$trashPath/";
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
if (isset($_POST['createtrash'])) {
  $newtrash = $_POST['newtrashName'];
  $newtrashPath = "$trashPath/$newtrash";
  if (!is_dir($newtrashPath)) {
    mkdir($newtrashPath, 0777, true);
    echo "Subcarpeta '$newtrash' creada con éxito.";
  } else {
    echo "La subcarpeta ya existe.";
  }
}

// Eliminar archivo
if (isset($_GET['deleteFile'])) {
  $fileToDelete = $_GET['deleteFile'];
  $filePathToDelete = "$trashPath/$fileToDelete";
  if (file_exists($filePathToDelete)) {
    unlink($filePathToDelete);
    echo "El archivo '$fileToDelete' ha sido eliminado.";
  } else {
    echo "El archivo no existe.";
  }
}

// Eliminar subcarpeta
if (isset($_GET['deletetrash'])) {
  $trashToDelete = $_GET['deletetrash'];
  $trashPathToDelete = "$trashPath/$trashToDelete";
  if (is_dir($trashPathToDelete)) {
    deletetrashAndContents($trashPathToDelete);
    echo "La subcarpeta '$trashToDelete' ha sido eliminada.";
  } else {
    echo "La subcarpeta no existe.";
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalles de la Carpeta - <?php echo htmlspecialchars($trashName); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="trash.css" rel="x stylesheet">
</head>
<body>

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
          <a class="nav-link" href="folders.php"><i class="bi bi-trash-fill"></i> Gestor de Carpetas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="escuelas/escuelas.php"><i class="bi bi-building"></i> Gestor de Escuelas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="inspectores/Inspectores.php"><i class="bi bi-person-badge-fill"></i> Gestor de Inspectores</a>
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

<header>
  <h1>Detalles de la Carpeta: <?php echo htmlspecialchars($trashName); ?></h1>
</header>

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
        <label for="newtrashName" class="form-label">Nombre de la subcarpeta</label>
        <input type="text" name="newtrashName" id="newtrashName" class="form-control" required>
      </div>
      <button type="submit" name="createtrash" class="btn btn-success btn-create-trash">Crear subcarpeta</button>
    </form>
  </div>

<div class="card p-4">
  <h3>Contenido</h3>
  <div class="row">
    <!-- Carpetas -->
    <div class="col-md-6">
      <h4>Carpetas</h4>
      <?php
        $items = array_diff(scandir($trashPath), array('.', '..'));
        $trash = array_filter($items, function($item) use ($trashPath) {
          return is_dir($trashPath . DIRECTORY_SEPARATOR . $item);
        });
        if (count($trash) === 0) {
          echo "<p>No hay carpetas.</p>";
        } else {
          echo '<ul class="list-group">';
          foreach ($trash as $trash) {
            $trashUrl = urlencode(trim($trashName === '' ? $trash : "$trashName/$trash"));
            echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                    <a href='?trash=$trashUrl' class='text-decoration-none'>
                      <i class='bi bi-trash-fill me-2'></i> $trash
                    </a>
                    <a href='?trash=" . urlencode($trashName) . "&deletetrash=" . urlencode($trash) . "' 
                      class='btn btn-sm btn-outline-danger btn-delete' 
                      onclick=\"return confirm('¿Seguro que quieres eliminar la carpeta $trash y todo su contenido?');\" 
                      title='Eliminar carpeta'>
                      <i class='bi bi-trash'></i>
                    </a>
                  </li>";
          }
          echo '</ul>';
        }
      ?>
    </div>

    <!-- Archivos -->
    <div class="col-md-6">
      <h4>Archivos</h4>
      <?php
        $files = array_filter($items, function($item) use ($trashPath) {
          return is_file($trashPath . DIRECTORY_SEPARATOR . $item);
        });
        if (count($files) === 0) {
          echo "<p>No hay archivos.</p>";
        } else {
          echo '<ul class="list-group">';
          foreach ($files as $file) {
            $filePath = "$trashPath/$file";
            echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                    <a href='$filePath' download class='text-decoration-none'>
                      <i class='bi bi-file-earmark-fill me-2'></i> $file
                    </a>
                    <a href='?trash=" . urlencode($trashName) . "&deleteFile=" . urlencode($file) . "' 
                      class='btn btn-sm btn-outline-danger btn-delete' 
                      onclick=\"return confirm('¿Seguro que quieres eliminar el archivo $file?');\" 
                      title='Eliminar archivo'>
                      <i class='bi bi-trash'></i>
                    </a>
                  </li>";
          }
          echo '</ul>';
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
