<?php
// schools.php
include 'includes/session.php';
include 'includes/conn.php';
include 'includes/modals/inspectorsmodals.php';

// Consulta para obtener inspectores con filtros
$where = [];
$params = [];

if (!empty($_GET['nombre'])) {
    $where[] = "name LIKE ?";
    $params[] = "%" . $_GET['nombre'] . "%";
}
if (!empty($_GET['cue'])) {
    $where[] = "cue LIKE ?";
    $params[] = "%" . $_GET['cue'] . "%";
}
if (!empty($_GET['nivel'])) {
    $where[] = "levelModality = ?";
    $params[] = $_GET['nivel'];
}

$sql = "SELECT * FROM inspectors";
if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$inspectors = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<?php $pageTitle = 'Listado de Escuelas'; include 'includes/header.php'; ?>
<style>
  body, html { height: 100%; margin: 0; background: #f8f9fa; }
  .main-container { min-height: 100vh; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border-radius: 12px; }
  .action-btns { min-width: 120px; }
  .schools-empty { text-align: center; color: #888; font-size: 1.1rem; margin-top: 2rem; }
  .btn-group-top { margin-bottom: 1.5rem; display: flex; flex-wrap: wrap; gap: 0.75rem; }
</style>
<?php include 'includes/navbar.php'; ?>
<div class="d-flex">
  <?php include 'includes/sidebar.php'; ?>
  <main class="main-container flex-grow-1 p-4">

    <h3><i class="fa-solid fa-school"></i> Listado de Escuelas</h3>

    <!-- Botones de agregar agrupados -->
    <div class="btn-group-top">
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddInspector">
          <i class="fa fa-plus"></i> Agregar inspector
      </button>
    </div>

    <!-- Filtros -->
    <form method="get" class="d-flex gap-2 flex-wrap mb-3 align-items-center">
      <input type="text" name="nombre" class="form-control" placeholder="Filtrar por nombre" style="max-width:180px;" value="<?= htmlspecialchars($_GET['nombre'] ?? '') ?>">
      <input type="text" name="cue" class="form-control" placeholder="Filtrar por CUE" style="max-width:120px;" value="<?= htmlspecialchars($_GET['cue'] ?? '') ?>">
      <select name="nivel" class="form-select" style="max-width:140px;">
        <option value="">Todos los niveles</option>
        <?php
        $stmtCatFilter = $pdo->query("SELECT name FROM categories ORDER BY name ASC");
        foreach ($stmtCatFilter->fetchAll(PDO::FETCH_COLUMN) as $catName) {
            $selected = (($_GET['nivel'] ?? '') === $catName) ? 'selected' : '';
            echo "<option value=\"" . htmlspecialchars($catName) . "\" $selected>" . htmlspecialchars($catName) . "</option>";
        }
        ?>
      </select>
      <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <!-- Tabla de inspectores -->
    <form id="exportForm" method="post" action="export_inspectors.php">
      <div class="table-responsive mt-2">
        <?php if (!$inspectors): ?>
            <div class="schools-empty">
              <i class="fa-solid fa-school"></i> No hay registros en la tabla de instituciones.
            </div>
        <?php else: ?>
            <table class="table table-striped table-hover align-middle">
              <thead>
                <tr>
                  <th><input type="checkbox" id="selectAll"></th>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Modalidad/Nivel</th>
                  <th>Teléfono</th>
                  <th>Email</th>
                  <th class="action-btns">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($inspectors as $inst): ?>
                  <tr>
                    <td><input type="checkbox" name="ids[]" value="<?= htmlspecialchars($inst['id']) ?>"></td>
                    <td><?= htmlspecialchars($inst['id']) ?></td>
                    <td><?= htmlspecialchars($inst['name']) ?></td>
                    <td><?= htmlspecialchars($inst['levelModality']) ?></td>
                    <td><?= htmlspecialchars($inst['phone']) ?></td>
                    <td><?= htmlspecialchars($inst['email']) ?></td>
                    <td class="action-btns">
                        <button type="button" class="btn btn-sm btn-primary me-1"
                            data-bs-toggle="modal" data-bs-target="#modalEditInspector"
                            data-id="<?= htmlspecialchars($inst['id']) ?>"
                            data-name="<?= htmlspecialchars($inst['name']) ?>"
                            data-levelmodality="<?= htmlspecialchars($inst['levelModality']) ?>"
                            data-phone="<?= htmlspecialchars($inst['phone']) ?>"
                            data-email="<?= htmlspecialchars($inst['email']) ?>"
                        >
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button"  class="btn btn-sm btn-danger"
                            data-bs-toggle="modal" data-bs-target="#modalDeleteInspector"
                            data-id="<?= htmlspecialchars($inst['id']) ?>"
                            data-name="<?= htmlspecialchars($inst['name']) ?>"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                  </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
        <?php endif; ?>
      </div>

      <button type="submit" class="btn btn-warning mt-2">
        <i class="fa fa-file-excel"></i> Exportar seleccionados a Excel
      </button>
    </form>

<?php include 'includes/footer.php'; ?>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Modal Eliminar Inspector
  var deleteModal = document.getElementById('modalDeleteInspector');
  if (deleteModal) {
    deleteModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      document.getElementById('deleteInspectorId').value = button.getAttribute('data-id');
      document.getElementById('deleteInspectorName').textContent = button.getAttribute('data-name');
    });
  }

  // Modal Editar Inspector
  var editModal = document.getElementById('modalEditInspector');
  if (editModal) {
    editModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      document.getElementById('editInspectorId').value = button.getAttribute('data-id');
      document.getElementById('editInspectorName').value = button.getAttribute('data-name');
      document.getElementById('editInspectorLevel').value = button.getAttribute('data-levelmodality');
      document.getElementById('editInspectorPhone').value = button.getAttribute('data-phone');
      document.getElementById('editInspectorEmail').value = button.getAttribute('data-email');
    });
  }

    // Seleccionar todos
      document.getElementById('selectAll').addEventListener('change', function() {
      document.querySelectorAll('input[name="ids[]"]').forEach(cb => cb.checked = this.checked);
    });
  });

</script>

</body>
</html>
