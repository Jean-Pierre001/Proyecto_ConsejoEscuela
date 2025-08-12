<?php
include 'includes/session.php';
include 'includes/conn.php';
include 'includes/modals/inspectorsmodals.php';

// Filtros para la consulta
$where = [];
$params = [];

if (!empty($_GET['nombre'])) {
    $where[] = "name LIKE ?";
    $params[] = "%" . $_GET['nombre'] . "%";
}

if (!empty($_GET['nivel'])) {
    $where[] = "levelModality = ?";
    $params[] = $_GET['nivel'];
}

$sql = "SELECT * FROM inspectors";
if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY id ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$inspectors = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Para llenar el select de niveles (levelModality)
$stmtLevelFilter = $pdo->query("SELECT DISTINCT levelModality FROM inspectors ORDER BY levelModality ASC");
$levels = $stmtLevelFilter->fetchAll(PDO::FETCH_COLUMN);

?>
<!DOCTYPE html>
<html lang="es">
<?php $pageTitle = 'Listado de Inspectores'; include 'includes/header.php'; ?>
<style>
  body, html { height: 100%; margin: 0; background: #f8f9fa; }
  .main-container { min-height: 100vh; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 12px; }
  .action-btns { min-width: 120px; }
  .schools-empty { text-align: center; color: #888; font-size: 1.1rem; margin-top: 2rem; }
  .btn-group-top { margin-bottom: 1.5rem; display: flex; flex-wrap: wrap; gap: 0.75rem; }
  .table-styles {
     padding:1%; box-shadow: 0 0px 6px rgba(0, 0, 0, 0.29); border-radius: 10px;
  }
  .table-responsive {
    padding:1%;
  }
  #i-inspectors { color: #007bff; margin-right: 1px; }
</style>
<?php include 'includes/navbar.php'; ?>
<div class="d-flex">
  <?php include 'includes/sidebar.php'; ?>
  <main class="main-container flex-grow-1 p-4">

    <h3><i id="i-inspectors" class="fa-solid fa-user-tie"></i> Listado de Inspectores</h3>

    <!-- Botone agregar -->
    <div class="btn-group-top">
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddInspector">
          <i class="fa fa-plus"></i> Agregar inspector
      </button>
    </div>

    <!-- Filtros -->
    <form method="get" class="d-flex gap-2 flex-wrap mb-3 align-items-center">
      <input type="text" name="nombre" class="form-control" placeholder="Filtrar por nombre" style="max-width:180px;" value="<?= htmlspecialchars($_GET['nombre'] ?? '') ?>">
      
      <select name="nivel" class="form-select" style="max-width:190px;">
        <option value="">Todos los niveles</option>
        <?php
        foreach ($levels as $level) {
            $selected = (($_GET['nivel'] ?? '') === $level) ? 'selected' : '';
            echo "<option value=\"" . htmlspecialchars($level) . "\" $selected>" . htmlspecialchars($level) . "</option>";
        }
        ?>
      </select>
      
      <button type="submit" class="btn btn-primary">Filtrar</button>

      <a href="inspectors.php" class="btn btn-secondary">Eliminar filtros</a>
    </form>


    <!-- Tabla de inspectores -->
    <form id="exportForm" method="post" action="export_inspectors.php">
      <div class="table-responsive mt-2">
        <?php if (!$inspectors): ?>
            <div class="schools-empty">
              <i class="fa-solid fa-school"></i> No hay registros en la tabla de instituciones.
            </div>
        <?php else: ?>
            <table class="table table-styles table-striped table-hover align-middle">
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

    <?php
    if (!empty($_SESSION['error'])) {
        echo "<script>toastr.error('" . addslashes($_SESSION['error']) . "');</script>";
        unset($_SESSION['error']);
    }
    if (!empty($_SESSION['success'])) {
        echo "<script>toastr.success('" . addslashes($_SESSION['success']) . "');</script>";
        unset($_SESSION['success']);
    }
    ?>

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
