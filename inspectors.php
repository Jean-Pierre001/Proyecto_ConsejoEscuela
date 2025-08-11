<?php
// schools.php
include 'includes/session.php';
include 'includes/conn.php';
include 'includes/modals/schoolsmodals.php'; // donde pondrás los modales que te paso después
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
  .btn-group-top {
    margin-bottom: 1.5rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
  }
</style>
<?php include 'includes/navbar.php'; ?>
<div class="d-flex">
  <?php include 'includes/sidebar.php'; ?>
  <main class="main-container flex-grow-1 p-4">

    <h3><i class="fa-solid fa-school"></i> Listado de Escuelas</h3>

    <!-- Botones de agregar agrupados -->
    <div class="btn-group-top">
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddSchool">
        <i class="fa fa-plus"></i> Agregar inspector
      </button>
    </div>

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

    <!-- Filtros -->
    <form method="get" class="d-flex gap-2 flex-wrap mb-3 align-items-center">
      <input type="text" name="nombre" class="form-control" placeholder="Filtrar por nombre" style="max-width:180px;" value="<?= htmlspecialchars($_GET['nombre'] ?? '') ?>">
      <input type="text" name="cue" class="form-control" placeholder="Filtrar por CUE" style="max-width:120px;" value="<?= htmlspecialchars($_GET['cue'] ?? '') ?>">
      <select name="nivel" class="form-select" style="max-width:140px;">
        <option value="">Todos los niveles</option>
        <?php
        $stmtCatFilter = $pdo->query("SELECT name FROM categories ORDER BY name ASC");
        $allCats = $stmtCatFilter->fetchAll(PDO::FETCH_COLUMN);
        foreach ($allCats as $catName) {
            $selected = (($_GET['nivel'] ?? '') === $catName) ? 'selected' : '';
            echo "<option value=\"" . htmlspecialchars($catName) . "\" $selected>" . htmlspecialchars($catName) . "</option>";
        }
        ?>
      </select>
      <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <div class="table-responsive mt-2">
    <?php
    // Consulta a la nueva tabla
    $sqlinspectors = "SELECT id, name, levelModality, phone, email FROM inspectors ORDER BY name ASC";
    $stmtinspectors = $pdo->prepare($sqlinspectors);
    $stmtinspectors->execute();
    $inspectors = $stmtinspectors->fetchAll(PDO::FETCH_ASSOC);

    if (!$inspectors) {
        echo '<div class="schools-empty"><i class="fa-solid fa-school"></i> No hay registros en la tabla de instituciones.</div>';
    } else {
        echo '<table class="table table-striped table-hover align-middle">';
        echo '<thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Modalidad/Nivel</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th class="action-btns">Acciones</th>
                </tr>
              </thead>
              <tbody>';
        foreach ($inspectors as $inst) {
            echo '<tr>
                    <td>' . htmlspecialchars($inst['id']) . '</td>
                    <td>' . htmlspecialchars($inst['name']) . '</td>
                    <td>' . htmlspecialchars($inst['levelModality']) . '</td>
                    <td>' . htmlspecialchars($inst['phone']) . '</td>
                    <td>' . htmlspecialchars($inst['email']) . '</td>
                    <td class="action-btns">
                        <button class="btn btn-sm btn-primary me-1"
                            data-bs-toggle="modal" data-bs-target="#modalEditInstitution"
                            data-id="' . htmlspecialchars($inst['id']) . '"
                            data-name="' . htmlspecialchars($inst['name']) . '"
                            data-levelmodality="' . htmlspecialchars($inst['levelModality']) . '"
                            data-phone="' . htmlspecialchars($inst['phone']) . '"
                            data-email="' . htmlspecialchars($inst['email']) . '"
                        >
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger"
                            data-bs-toggle="modal" data-bs-target="#modalDeleteInstitution"
                            data-id="' . htmlspecialchars($inst['id']) . '"
                            data-name="' . htmlspecialchars($inst['name']) . '"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                  </tr>';
        }
        echo '</tbody></table>';
    }
    ?>
    </div>

<?php include 'includes/footer.php'; ?>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

</body>
</html>
