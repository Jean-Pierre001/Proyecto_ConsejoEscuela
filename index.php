<?php
session_start();
include 'baseDatos/conexion.php';

if (isset($_GET['nombre_usuario'])) {
    $nombre_usuario = $_GET['nombre_usuario'];
    $_SESSION['nombre_usuario'] = $nombre_usuario; 

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="img/consejoicono.ico" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="index.css" rel="stylesheet">
</head>
<body>  

<div class="position-fixed top-50 start-50 translate-middle text-center text-white" style="opacity: 1.0;">
  <h1 class="display-4">Bienvenido/a <?= htmlspecialchars($_SESSION['nombre_usuario']) ?> </h1>
</div>


<!-- Sidebar fijo a la izquierda -->
<div class="sidebar bg-light border-end position-fixed vh-100" style="width: 25%; z-index: 1030;">
  <!-- Encabezado con imagen centrada -->
  <div class="d-flex flex-column align-items-center p-3">
    <img src="img/consejologo.png" alt="Icono del Consejo" class="img-fluid" style="max-width: 50%;">
  </div>

  <!-- Menú de navegación -->
  <div class="px-3">
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

<nav id="mainNavbar" class="navbar navbar-expand-lg sticky-top">
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item border mx-5">
      <a class="nav-link bi bi-bank2" href="../folders.php">Carpetas</a>
      </li>
      <li class="nav-item border mx-5">
      <a class="nav-link bi bi-bank2" href="../folders.php">Carpetas</a>
      </li>
      <li class="nav-item border mx-5">
      <a class="nav-link bi bi-bank2" href="../folders.php">Carpetas</a>
      </li>
      <li class="nav-item border mx-5">
      <a class="nav-link bi bi-bank2" href="../folders.php">Carpetas</a>
      </li>
      <li class="nav-item border mx-5">
      <a class="nav-link bi bi-bank2" href="../folders.php">Carpetas</a>
      </li>
    </ul>
  </div>
</nav>

<!-- Bootstrap JS (con Popper incluido) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Abrir modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
  Agregar Escuela
</button>

<!-- Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Encabezado de Modal -->
      <div class="modal-header">
        <h4 class="modal-title">Agregar Escuela</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body de Modal -->
      <div class="modal-body">
        <div class="container">
    <form action="" method="POST">
        <label for="turno"></label>
        <input type="text" id="turno" name="turno" required placeholder="Turno">

        <label for="servicio"></label>
        <input type="text" id="servicio" name="servicio" required placeholder="Servicio">

        <label>
            <input type="checkbox" name="edificio_compartido">
            ¿Edificio compartido?
        </label>

        <label for="cue"></label>
        <input type="text" id="cue" name="cue" required placeholder="CUE">

        <label for="direccion"></label>
        <input type="text" id="direccion" name="direccion" required placeholder="Dirección">

        <label for="localidad"></label>
        <input type="text" id="localidad" name="localidad" required placeholder="Localidad">

        <label for="telefono"></label>
        <input type="text" id="telefono" name="telefono" required placeholder="Teléfono">

        <label for="correo_electronico"></label>
        <input type="email" id="correo_electronico" name="correo_electronico" required placeholder="Correo Electrónico">

        <label for="directivo"></label>
        <input type="text" id="directivo" name="directivo" required placeholder="Directivo">

        <label for="vicedirectora"></label>
        <input type="text" id="vicedirectora" name="vicedirectora" required placeholder="Vicedirector/a">

        <label for="secretaria"></label>
        <input type="text" id="secretaria" name="secretaria" required placeholder="Secretario/a">

        <button type="submit" class="btn btn-agregar">Agregar Escuela</button>
    </form>
        </div>
      </div>
  </div>
</div>
</body>
</html>
