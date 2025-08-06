<?php
// schools.php
include 'includes/session.php';
include 'includes/conn.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php $pageTitle = 'Listado de Escuelas'; include 'includes/header.php'; ?>
<style>
  body, html { height: 100%; margin: 0; background: #f8f9fa; }
  .main-container { min-height: 100vh; background: #f8f9fa; }
  .action-btns { min-width: 120px; }
  .schools-empty {
    text-align: center;
    color: #888;
    font-size: 1.1rem;
    margin-top: 2rem;
  }
  .fa-school { color: #007bff; margin-right: 8px; }
</style>
<?php include 'includes/navbar.php'; ?>
<div class="d-flex">
  <?php include 'includes/sidebar.php'; ?>
  <main class="main-container flex-grow-1 p-4">
    <h3><i class="fa-solid fa-school"></i> Listado de Escuelas</h3>
    <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
      <button class="btn btn-success" id="add-school-btn"><i class="fa fa-plus"></i> Agregar escuela</button>
      <div class="d-flex gap-2 flex-wrap">
        <input type="text" class="form-control" id="filter-name" placeholder="Filtrar por nombre" style="max-width:180px;">
        <input type="text" class="form-control" id="filter-cue" placeholder="Filtrar por CUE" style="max-width:120px;">
        <select class="form-select" id="filter-level" style="max-width:140px;">
          <option value="">Todos los niveles</option>
          <option value="Primario">Primario</option>
          <option value="Secundario">Secundario</option>
        </select>
      </div>
    </div>
    <div id="schools-table-container" class="table-responsive mt-2"></div>
  </main>
</div>
<?php include 'includes/footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="assets/libs/animate/animate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<script src="assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
<script>
let schoolsData = [];

function renderSchoolsTable(schools) {
  if (schools.length === 0) {
    document.getElementById('schools-table-container').innerHTML = '<div class="schools-empty"><i class="fa-solid fa-school"></i> No hay escuelas registradas.</div>';
    return;
  }
  let tableHtml = `<table class=\"table table-striped table-hover align-middle\">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>CUE</th>
        <th>Dirección</th>
        <th>Teléfono</th>
        <th>Director/a</th>
        <th>Nivel</th>
        <th class=\"action-btns\">Acciones</th>
      </tr>
    </thead>
    <tbody>`;
  tableHtml += schools.map((s, idx) => `
    <tr>
      <td><i class=\"fa-solid fa-school\"></i> ${s.nombre}</td>
      <td>${s.cue}</td>
      <td>${s.direccion}</td>
      <td>${s.telefono}</td>
      <td>${s.director}</td>
      <td>${s.nivel}</td>
      <td class=\"action-btns\">
        <button class=\"btn btn-sm btn-primary me-1\" title=\"Editar\"><i class=\"fa fa-edit\"></i></button>
        <button class=\"btn btn-sm btn-danger\" title=\"Eliminar\"><i class=\"fa fa-trash\"></i></button>
      </td>
    </tr>
  `).join('');
  tableHtml += '</tbody></table>';
  document.getElementById('schools-table-container').innerHTML = tableHtml;
}

function loadSchoolsTable() {
  fetch('list_schools.php')
    .then(res => res.json())
    .then(data => {
      if (!data.success || !Array.isArray(data.schools)) {
        toastr.error('No se pudieron cargar las escuelas');
        return;
      }
      schoolsData = data.schools;
      renderSchoolsTable(schoolsData);
    })
    .catch(() => toastr.error('Error al cargar la tabla de escuelas'));
}

document.addEventListener('DOMContentLoaded', () => {
  loadSchoolsTable();

  // Filtros
  document.getElementById('filter-name').addEventListener('input', applyFilters);
  document.getElementById('filter-cue').addEventListener('input', applyFilters);
  document.getElementById('filter-level').addEventListener('change', applyFilters);

  // Botón agregar escuela (base para funcionalidad)
  document.getElementById('add-school-btn').addEventListener('click', () => {
    Swal.fire({
      title: 'Agregar escuela',
      html: '<input id="swal-nombre" class="swal2-input" placeholder="Nombre">' +
            '<input id="swal-cue" class="swal2-input" placeholder="CUE">',
      showCancelButton: true,
      confirmButtonText: 'Guardar',
      cancelButtonText: 'Cancelar',
      preConfirm: () => {
        const nombre = document.getElementById('swal-nombre').value;
        const cue = document.getElementById('swal-cue').value;
        if (!nombre || !cue) {
          Swal.showValidationMessage('Completa todos los campos');
          return false;
        }
        // Aquí iría la lógica para guardar la escuela (AJAX)
        toastr.success('Escuela agregada (demo)');
      }
    });
  });
});

function applyFilters() {
  const nameVal = document.getElementById('filter-name').value.toLowerCase();
  const cueVal = document.getElementById('filter-cue').value.toLowerCase();
  const levelVal = document.getElementById('filter-level').value;
  let filtered = schoolsData.filter(s => {
    return (
      (!nameVal || s.nombre.toLowerCase().includes(nameVal)) &&
      (!cueVal || s.cue.toLowerCase().includes(cueVal)) &&
      (!levelVal || s.nivel === levelVal)
    );
  });
  renderSchoolsTable(filtered);
}
</script>
</body>
</html>
