<?php
require_once '../baseDatos/conexion.php';

$cue = isset($_POST['cue']) ? $_POST['cue'] : '';

$sql = "SELECT id, nombreEscuela, CUE, turno, servicio, direccion, localidad, telefono, correoElectronico, directivo FROM escuelas WHERE 1=1";

// Filtrar por CUE si se ha ingresado uno, (30/05: cambien esto a otros metodos, los del consejo no usan los CUE, atte: gordo silla).
if ($cue) {
    $sql .= " AND CUE LIKE :cue";
}

try {
    $stmt = $pdo->prepare($sql);
    if ($cue) {
        $stmt->bindValue(':cue', $cue . '%');
    }
    $stmt->execute();
} catch (PDOException $e) {
    die("Error al consultar la base de datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Listado de Escuelas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="estilos/escuela.css">
</head>
<body>

<header class="text-white bg-primary p-4 text-center">
  <i class="bi bi-people"></i>
  <h1>Gestor de Escuelas</h1>
</header>

  <!-- Offcanvas Sidebar -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="demo" aria-labelledby="demoLabel">
    <!-- Encabezado con imagen centrada -->
    <div class="offcanvas-header flex-column align-items-center">
      <button type="button" class="btn-close text-reset mt-3" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
      <div class="w-100 text-center">
        <img src="../img/consejologo.png" alt="Icono del Consejo" class="img-fluid" style="max-width: 50%;" />
      </div>
    </div>

    <!-- Cuerpo con menú de navegación -->
    <div class="offcanvas-body">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link" href="../index.php"><i class="bi bi-house-door-fill"></i> Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../folders.php"><i class="bi bi-folder-fill"></i> Gestor de Carpetas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="escuelas.php"><i class="bi bi-building"></i> Gestor de Escuelas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../inspectores/inspectores.php"><i class="bi bi-person-badge-fill"></i> Gestor de Inspectores</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../usuarios/usuarios.php"><i class="bi bi-people-fill"></i> Gestor de Usuarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../trash.php"><i class="bi bi-trash-fill"></i> Papelera</a>
        </li>
      </ul>
    </div>
  </div>

  <!-- Navbar principal -->
  <nav id="mainNavbar" class="navbar navbar-expand-lg sticky-top">
    <div class="container"> <!-- CAMBIAR CLASE -->
      <!-- Botón para abrir el sidebar -->
      <button class="btn btn-primary m-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#demo" aria-controls="demo">
        <i class="bi bi-list"></i> Consejo Escolar
      </button>
    </div>
  </nav>

<div class="container my-5">

  <?php if (isset($_GET['mensaje'])): ?>
    <div class="alert alert-info"><?= htmlspecialchars($_GET['mensaje']) ?></div>
  <?php endif; ?>

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary">Listado de Escuelas</h2>
    <a href="agregarEscuela.php" class="btn btn-success">
      <i class="bi bi-person-plus-fill"></i> Agregar escuela
    </a>
  </div>

  <!-- Formulario de búsqueda -->
  <form method="POST" class="mb-4">
    <div class="row">
      <div class="col-md-4 mb-3">
        <input type="text" name="cue" class="form-control" placeholder="Filtrar por CUE" value="<?= htmlspecialchars($cue) ?>">
      </div>
      <div class="col-md-4 mb-3">
        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
      </div>
    </div>
  </form>
</div>
  <div class="container my-5">
  <div class="table-responsive rounded-3">
    <table class="table table-bordered table-hover align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>Nombre escuela</th>
          <th>CUE</th>
          <th>Turno</th>
          <th>Servicio</th>
          <th>Dirección</th>
          <th>Localidad</th>
          <th>Teléfono</th>
          <th>Correo</th>
          <th>Directivo</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
          <tr>
            <td><?= htmlspecialchars($row['nombreEscuela']) ?></td>
            <td><?= htmlspecialchars($row['CUE']) ?></td>
            <td><?= htmlspecialchars($row['turno']) ?></td>
            <td><?= htmlspecialchars($row['servicio']) ?></td>
            <td><?= htmlspecialchars($row['direccion']) ?></td>
            <td><?= htmlspecialchars($row['localidad']) ?></td>
            <td><?= htmlspecialchars($row['telefono']) ?></td>
            <td><?= htmlspecialchars($row['correoElectronico']) ?></td>
            <td><?= htmlspecialchars($row['directivo']) ?></td>
            <td>
              <a href="../folders.php?CUE=<?= $row['CUE'] ?>" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a>
              <a href="EditarEscuela.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
              <a href="EliminarEscuela.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></a>
              <a href="../crearCarpeta.php?CUE=<?= urlencode($row['CUE']) ?>&nombreEscuela=<?= urlencode($row['nombreEscuela']) ?>&localidad=<?= urlencode($row['localidad']) ?>" class="btn btn-secondary btn-sm" title="Crear carpeta para esta escuela">
                <i class="bi bi-folder-plus"></i>
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
          