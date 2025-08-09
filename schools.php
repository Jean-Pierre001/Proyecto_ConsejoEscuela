<?php
// schools.php
include 'includes/session.php';
include 'includes/conn.php';
include 'includes/modals/schoolsmodals.php';


?>
<!DOCTYPE html>
<html lang="es">
<?php $pageTitle = 'Listado de Escuelas'; include 'includes/header.php'; ?>
<style>
  body, html { height: 100%; margin: 0; background: #f8f9fa; }
  .main-container { min-height: 100vh; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border-radius: 12px; }
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
    <?php if (isset($_GET['error']) && $_GET['error'] === 'folder_exists'): ?>
  <div class="alert alert-warning" role="alert">
    La carpeta para esta escuela ya existe.
  </div>
<?php endif; ?>

<?php if (isset($_GET['created_folder'])): ?>
  <div class="alert alert-success" role="alert">
    Se creó la carpeta: <strong><?= htmlspecialchars($_GET['created_folder']) ?></strong>
  </div>
<?php endif; ?>

    <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddSchool">
        <i class="fa fa-plus"></i> Agregar escuela
      </button>
      <form method="get" class="d-flex gap-2 flex-wrap">
        <input type="text" name="nombre" class="form-control" placeholder="Filtrar por nombre" style="max-width:180px;" value="<?= htmlspecialchars($_GET['nombre'] ?? '') ?>">
        <input type="text" name="cue" class="form-control" placeholder="Filtrar por CUE" style="max-width:120px;" value="<?= htmlspecialchars($_GET['cue'] ?? '') ?>">
        <select name="nivel" class="form-select" style="max-width:140px;">
          <option value="">Todos los niveles</option>
          <option value="Primario" <?= (($_GET['nivel'] ?? '') === 'Primario') ? 'selected' : '' ?>>Primario</option>
          <option value="Secundario" <?= (($_GET['nivel'] ?? '') === 'Secundario') ? 'selected' : '' ?>>Secundario</option>
        </select>
        <button type="submit" class="btn btn-primary">Filtrar</button>
      </form>
    </div>

    <div class="table-responsive mt-2">
      <?php
      // Construir consulta con filtros
      $sql = "SELECT id, schoolName AS nombre, cue, address AS direccion, phone AS telefono, principal AS director, service AS nivel FROM schools WHERE 1=1";
      $params = [];

      if (!empty($_GET['nombre'])) {
          $sql .= " AND schoolName LIKE :nombre";
          $params[':nombre'] = '%' . $_GET['nombre'] . '%';
      }
      if (!empty($_GET['cue'])) {
          $sql .= " AND cue LIKE :cue";
          $params[':cue'] = '%' . $_GET['cue'] . '%';
      }
      if (!empty($_GET['nivel'])) {
          $sql .= " AND service = :nivel";
          $params[':nivel'] = $_GET['nivel'];
      }

      $sql .= " ORDER BY schoolName ASC";
      $stmt = $pdo->prepare($sql);
      $stmt->execute($params);
      $schools = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if (count($schools) === 0) {
          echo '<div class="schools-empty"><i class="fa-solid fa-school"></i> No hay escuelas registradas.</div>';
      } else {
          echo '<table class="table table-striped table-hover align-middle">';
          echo '<thead>
                  <tr>
                    <th>Nombre</th>
                    <th>CUE</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Director/a</th>
                    <th>Nivel</th>
                    <th class="action-btns">Acciones</th>
                  </tr>
                </thead>
                <tbody>';
                foreach ($schools as $s) {
                    echo '<tr>
                            <td><i class="fa-solid fa-school"></i> ' . htmlspecialchars($s['nombre']) . '</td>
                            <td>' . htmlspecialchars($s['cue']) . '</td>
                            <td>' . htmlspecialchars($s['direccion']) . '</td>
                            <td>' . htmlspecialchars($s['telefono']) . '</td>
                            <td>' . htmlspecialchars($s['director']) . '</td>
                            <td>' . htmlspecialchars($s['nivel']) . '</td>
                            <td class="action-btns">
                              <a href="#" class="btn btn-sm btn-primary me-1" 
                                data-bs-toggle="modal" data-bs-target="#modalEditSchool"
                                data-id="' . $s['id'] . '"
                                data-nombre="' . htmlspecialchars($s['nombre']) . '"
                                data-cue="' . htmlspecialchars($s['cue']) . '"
                                data-shift="' . htmlspecialchars($s['shift'] ?? '') . '"
                                data-address="' . htmlspecialchars($s['direccion']) . '"
                                data-city="' . htmlspecialchars($s['city'] ?? '') . '"
                                data-phone="' . htmlspecialchars($s['telefono']) . '"
                                data-principal="' . htmlspecialchars($s['director']) . '"
                                data-viceprincipal="' . htmlspecialchars($s['vicePrincipal'] ?? '') . '"
                                data-secretary="' . htmlspecialchars($s['secretary'] ?? '') . '"
                                data-service="' . htmlspecialchars($s['nivel']) . '"
                                data-sharedbuilding="' . htmlspecialchars($s['sharedBuilding'] ?? '') . '"
                                data-email="' . htmlspecialchars($s['email'] ?? '') . '">
                                <i class="fa fa-edit"></i>
                              </a>
                              <a href="school_delete.php?id=' . $s['id'] . '" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm(\'¿Seguro que deseas eliminar esta escuela?\')"><i class="fa fa-trash"></i></a>
                              <a href="create_folder_and_redirect.php?id=' . $s['id'] . '" class="btn btn-sm btn-secondary" title="Archivos">
                                <i class="fa fa-file"></i>
                              </a>
                            </td>
                          </tr>';
          }
          echo '</tbody></table>';
      }
      ?>
    </div>
  </main>
</div>
<?php include 'includes/footer.php'; ?>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var editModal = document.getElementById('modalEditSchool');
  editModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    document.getElementById('edit-id').value = button.getAttribute('data-id');
    document.getElementById('edit-schoolName').value = button.getAttribute('data-nombre');
    document.getElementById('edit-cue').value = button.getAttribute('data-cue');
    document.getElementById('edit-shift').value = button.getAttribute('data-shift');
    document.getElementById('edit-address').value = button.getAttribute('data-address');
    document.getElementById('edit-city').value = button.getAttribute('data-city');
    document.getElementById('edit-phone').value = button.getAttribute('data-phone');
    document.getElementById('edit-principal').value = button.getAttribute('data-principal');
    document.getElementById('edit-vicePrincipal').value = button.getAttribute('data-viceprincipal');
    document.getElementById('edit-secretary').value = button.getAttribute('data-secretary');
    document.getElementById('edit-service').value = button.getAttribute('data-service');
    document.getElementById('edit-sharedBuilding').value = button.getAttribute('data-sharedbuilding');
    document.getElementById('edit-email').value = button.getAttribute('data-email');
  });
});
</script>

</body>
</html>
