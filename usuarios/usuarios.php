<?php
require_once '../baseDatos/conexion.php';

$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
$contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';

$sql = "SELECT id_usuario, usuario, contrasena, rol FROM usuarios WHERE 1=1";

// Filtrar por usuario si se ha ingresado un usuario
if ($usuario) {
    $sql .= " AND usuario LIKE :usuario";
}

// Agregar orden alfabético por usuario y apellido si no hay filtros
$sql .= " ORDER BY usuario"; // Esto asegura que los Usuarios se ordenen alfabéticamente por su usuario y apellido

try {
    $stmt = $pdo->prepare($sql);

    // Enlazar los parámetros si se han proporcionado
    if ($usuario) {
        $stmt->bindValue(':usuario', '%' . $usuario . '%');
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listado de Usuarios</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      background: linear-gradient(180deg, #f5f7fa 0%, #c3cfe2 100%);
      font-family: 'Segoe UI', sans-serif;
    }

    header {
      background: linear-gradient(90deg, #4A90E2, #50A7F3);
      padding: 5px 0;
      color: white;
      text-align: center;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
    }

    header h1 {
      font-size: 2.5rem;
      font-weight: bold;
      margin-bottom: 10px;
    }

    header i {
      font-size: 2rem;
    }

    .navbar {
      transition: all 0.3s ease;
      background-color: white;
      padding-top: 1rem;
      padding-bottom: 1rem;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
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

    .nav-link:hover,
    .nav-item.dropdown:hover .nav-link {
      color: #f6b800 !important;
    }

    .dropdown-menu {
      border: none;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body class="bg-light">

  <header>
    <i class="bi bi-people fs-1"></i>
    <h1>Gestor de Usuarios</h1>
    <p class="lead">Agrega, da de baja y modifica los usuarios de la página web</p>
  </header>

  <nav id="mainNavbar" class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand" href="../index.php">
        <span>Cooperativa</span>Comarca Ltda.
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="Usuarios.php">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="../usuarios/usuarios.php">Usuarios</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">Servicios</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../folders.php">Gestión de carpetas</a></li>
              <li><a class="dropdown-item" href="../contable.php">Gestión contable</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
 
  <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="text-primary">Listado de Usuarios</h2>
      <a href="agregarUsuario.php" class="btn btn-success">
        <i class="bi bi-person-plus-fill"></i> Agregar Usuario
      </a>
    </div>

    <!-- Filtro por usuario y contrasena -->
    <form method="POST" class="mb-4">
      <div class="row">
        <div class="col-md-4 mb-3">
          <input type="text" name="usuario" class="form-control" placeholder="Filtrar por usuario" value="<?= htmlspecialchars($usuario) ?>">
        </div>
        <div class="col-md-4 mb-3">
          <input type="text" name="contrasena" class="form-control" placeholder="Filtrar por contrasena" value="<?= htmlspecialchars($contrasena) ?>">
        </div>
        <div class="col-md-4 mb-3">
          <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-striped table-hover table-bordered align-middle shadow-sm">
        <thead class="table-dark text-center">
          <tr>
            <th>Usuario</th>
            <th>Contraseña</th>
            <th>Rol</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
              <td><?= htmlspecialchars($row['usuario']) ?></td>
              <td><?= htmlspecialchars($row['contrasena']) ?></td>
              <td><?= htmlspecialchars($row['rol']) ?></td>
              <td>
                <a href="editarUsuario.php?id=<?= $row['id_usuario'] ?>" class="btn btn-warning btn-sm me-1">
                  <i class="bi bi-pencil-fill"></i>
                </a>
                <a href="eliminarUsuario.php?id=<?= $row['id_usuario'] ?>" class="btn btn-danger btn-sm">
                  <i class="bi bi-trash-fill"></i>
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const navbar = document.getElementById('mainNavbar');
    window.addEventListener('scroll', function () {
      if (window.scrollY > 100) {
        navbar.classList.add('shrink');
      } else {
        navbar.classList.remove('shrink');
      }
    });
  </script>
</body>
</html>
