<div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 250px; height: 100vh;">
  <h5 class="text-center">Menú</h5>
  <hr>
  <ul class="nav nav-pills flex-column">
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    ?>
    <li class="nav-item">
      <a href="index.php" class="nav-link<?php echo ($currentPage == 'index.php') ? ' active' : ''; ?>">
        <i class="fa-solid fa-folder"></i> Archivos
      </a>
    </li>
    <li class="nav-item">
      <a href="schools.php" class="nav-link<?php echo ($currentPage == 'schools.php') ? ' active' : ''; ?>">
        <i class="fa-solid fa-school"></i> Escuelas
      </a>
    </li>
    <li class="nav-item">
      <a href="inspectors.php" class="nav-link<?php echo ($currentPage == 'inspectors.php') ? ' active' : ''; ?>">
        <i class="fa-solid fa-user-tie"></i> Inspectores
      </a>
    </li>
    <li class="nav-item">
      <a href="https://www.citypopulation.de/es/argentina/admin/buenos_aires/06602__patagones/" class="nav-link">
        <i class="fa-solid fa-users"></i> Poblacion
      </a>
    </li>
    <li class="nav-item">
      <a href="https://www.argentina.gob.ar/capital-humano/educacion" class="nav-link">
        <i class="fa-solid fa-graduation-cap"></i> Educación
      </a>
    </li>
  </ul>
</div>
