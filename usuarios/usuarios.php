<?php
require_once '../baseDatos/conexion.php';

$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';

$sql = "SELECT id_usuario, nombre, contrasena, tipo, correo, telefono FROM usuarios WHERE 1=1";

if ($nombre) {
    $sql .= " AND nombre LIKE :nombre";
}

try {
    $stmt = $pdo->prepare($sql);
    if ($nombre) {
        $stmt->bindValue(':nombre', $nombre . '%');
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
  <title>Gestor de Usuarios</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

<header class="text-white bg-primary p-4 text-center">
  <h1><i class="bi bi-person-badge-fill"></i> Gestor de Usuarios</h1>
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
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>

<div class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary">Listado de Usuarios</h2>
    <a href="agregarUsuario.php" class="btn btn-success">
      <i class="bi bi-person-plus-fill"></i> Agregar usuario
    </a>
  </div>

  <!-- Formulario de búsqueda -->
  <form method="POST" class="mb-4">
    <div class="row">
      <div class="col-md-4 mb-3">
        <input type="text" name="nombre" class="form-control" placeholder="Filtrar por nombre" value="<?= htmlspecialchars($nombre) ?>">
      </div>
      <div class="col-md-4 mb-3">
        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
      </div>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>Nombre</th>
          <th>Contraseña</th>
          <th>Tipo</th>
          <th>Correo</th>
          <th>Teléfono</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
          <tr>
            <td><?= htmlspecialchars($row['nombre']) ?></td>
            <td>**************</td>
            <td><?= htmlspecialchars($row['tipo']) ?></td>
            <td><?= htmlspecialchars($row['correo']) ?></td>
            <td><?= htmlspecialchars($row['telefono']) ?></td>
            <td>
              <a href="editarUsuario.php?id_usuario=<?= $row['id_usuario'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
              <a href="eliminarUsuario.php?id_usuario=<?= $row['id_usuario'] ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></a>
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
