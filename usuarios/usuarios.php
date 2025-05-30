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
  <style>
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
      padding: 6px 6px;
      background-color: #1d3a8a;
      color:rgb(231, 234, 241) !important;
      font-weight: bold;
      border-radius: 3px;
      margin-right: 4px;
    }
    .nav-item.dropdown:hover .nav-link {
      color: #f6b800 !important;
    }

    .dropdown-menu {
      border: none;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

<header class="text-white bg-primary p-4 text-center">
  <h1><i class="bi bi-person-badge-fill"></i> Gestor de Usuarios</h1>
</header>

<!-- Navbar principal -->
<nav id="mainNavbar" class="navbar navbar-expand-lg sticky-top">
  <div class="container">
    <a class="navbar-brand" href="../index.php">
      <span class="bi bi-house-door-fill"> Consejo Escolar </span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="../folders.php">Carpetas</a></li>
      </ul>
    </div>
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
