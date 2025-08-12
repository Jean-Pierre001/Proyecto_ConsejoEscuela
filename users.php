<?php
include 'includes/session.php';
include 'includes/conn.php';
include 'includes/modals/usersmodals.php';

// Filtros para la consulta
$where = [];
$params = [];

if (!empty($_GET['username'])) {
    $where[] = "username LIKE ?";
    $params[] = "%" . $_GET['username'] . "%";
}

if (!empty($_GET['role'])) {
    $where[] = "role = ?";
    $params[] = $_GET['role'];
}

$sql = "SELECT * FROM users";
if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY id ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Para llenar el select de roles
$stmtRoleFilter = $pdo->query("SELECT DISTINCT role FROM users ORDER BY role ASC");
$roles = $stmtRoleFilter->fetchAll(PDO::FETCH_COLUMN);

?>
<!DOCTYPE html>
<html lang="es">
<?php $pageTitle = 'Listado de Usuarios'; include 'includes/header.php'; ?>
<style>
  body, html { height: 100%; margin: 0; background: #f8f9fa; }
  .main-container { min-height: 100vh; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border-radius: 12px; }
  .action-btns { min-width: 120px; }
  .schools-empty { text-align: center; color: #888; font-size: 1.1rem; margin-top: 2rem; }
  .btn-group-top { margin-bottom: 1.5rem; display: flex; flex-wrap: wrap; gap: 0.75rem; }
  #i-users { color: #007bff; margin-right: 1px; }
</style>
<?php include 'includes/navbar.php'; ?>
<div class="d-flex">
  <?php include 'includes/sidebar.php'; ?>
  <main class="main-container flex-grow-1 p-4">

    <h3><i id="i-users" class="fa-solid fa-user"></i> Listado de Usuarios</h3>

    <!-- Botón agregar (ajústalo según tu modal para usuarios) -->
    <div class="btn-group-top">
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddUser">
          <i class="fa fa-plus"></i> Agregar usuario
      </button>
    </div>

    <!-- Filtros -->
    <form method="get" class="d-flex gap-2 flex-wrap mb-3 align-items-center">
      <input type="text" name="username" class="form-control" placeholder="Filtrar por usuario" style="max-width:180px;" value="<?= htmlspecialchars($_GET['username'] ?? '') ?>">
      
      <select name="role" class="form-select" style="max-width:190px;">
        <option value="">Todos los roles</option>
        <?php
        foreach ($roles as $role) {
            $selected = (($_GET['role'] ?? '') === $role) ? 'selected' : '';
            echo "<option value=\"" . htmlspecialchars($role) . "\" $selected>" . htmlspecialchars(ucfirst($role)) . "</option>";
        }
        ?>
      </select>
      
      <button type="submit" class="btn btn-primary">Filtrar</button>

      <a href="users.php" class="btn btn-secondary">Eliminar filtros</a>
    </form>

    <!-- Tabla de usuarios -->
      <div class="table-responsive mt-2">
        <?php if (!$users): ?>
            <div class="schools-empty">
              <i class="fa-solid fa-users"></i> No hay registros en la tabla de usuarios.
            </div>
        <?php else: ?>
            <table class="table table-striped table-hover align-middle">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Usuario</th>
                  <th>Email</th>
                  <th>Rol</th>
                  <th>Fecha de creación</th>
                  <th class="action-btns">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($users as $user): ?>
                  <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars(ucfirst($user['role'])) ?></td>
                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                    <td class="action-btns">
                        <button type="button" class="btn btn-sm btn-primary me-1"
                            data-bs-toggle="modal" data-bs-target="#modalEditUser"
                            data-id="<?= htmlspecialchars($user['id']) ?>"
                            data-username="<?= htmlspecialchars($user['username']) ?>"
                            data-email="<?= htmlspecialchars($user['email']) ?>"
                            data-role="<?= htmlspecialchars($user['role']) ?>"
                        >
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button"  class="btn btn-sm btn-danger"
                            data-bs-toggle="modal" data-bs-target="#modalDeleteUser"
                            data-id="<?= htmlspecialchars($user['id']) ?>"
                            data-username="<?= htmlspecialchars($user['username']) ?>"
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
  // Modal Eliminar Usuario
  var deleteModal = document.getElementById('modalDeleteUser');
  if (deleteModal) {
    deleteModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      document.getElementById('deleteUserId').value = button.getAttribute('data-id');
      document.getElementById('deleteUserName').textContent = button.getAttribute('data-username');
    });
  }

  // Modal Editar Usuario
  var editModal = document.getElementById('modalEditUser');
  if (editModal) {
    editModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      document.getElementById('editUserId').value = button.getAttribute('data-id');
      document.getElementById('editUserName').value = button.getAttribute('data-username');
      document.getElementById('editUserEmail').value = button.getAttribute('data-email');
      document.getElementById('editUserRole').value = button.getAttribute('data-role');
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
