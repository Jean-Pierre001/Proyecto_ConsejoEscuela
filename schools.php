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
  body, html { height: 100%; margin: 0; background: #f8f9fa;}
  .main-container { min-height: 100vh; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 12px;  overflow:hidden;}
  .action-btns { min-width: 120px; }
  .schools-empty {
    text-align: center;
    color: #888;
    font-size: 1.1rem;
    margin-top: 2rem;
  }
  .table-styles {
    padding:1%; box-shadow: 0 0px 4px rgba(0, 0, 0, 0.29); border-radius: 10px;
  }
  .title-container {
    background-image: linear-gradient(to right, #f0f4fdff, #2885ffff); padding:1%; box-shadow: 0 0px 8px rgba(0, 0, 0, 0.2); border-radius: 12px;
  }
  .table-responsive {
    padding:1%; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2); border-radius: 12px;
  }
  #i-school { color: #007bff; margin-right: 1px; }
  .btn-group-top {
    margin-bottom: 1.5rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
  }
</style>
<?php include 'includes/navbar.php'; ?>
<div class="d-flex flex-grow-1">
  <?php include 'includes/sidebar.php'; ?>
  <main class="main-container flex-grow-1 p-4">

    <h3><i id="i-school" class="fa-solid fa-school"></i> Listado de Escuelas</h3>

    <!-- Botones de agregar agrupados -->
    <div class="btn-group-top">
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddCategory">
        <i class="fa fa-plus"></i> Agregar Categoría
      </button>
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddSchool">
        <i class="fa fa-plus"></i> Agregar Escuela
      </button>
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddAuthority">
        <i class="fa fa-plus"></i> Agregar Autoridad
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
      <input type="text" name="cue" class="form-control" placeholder="Filtrar por CUE" style="max-width:180px;" value="<?= htmlspecialchars($_GET['cue'] ?? '') ?>">
      <select name="nivel" class="form-select" style="max-width:180px;">
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
      <a href="schools.php" class="btn btn-secondary">Eliminar filtros</a>
    </form>
<form id="exportForm" method="post" action="export_schools.php">
  <div class="table-responsive mt-2">
    <?php
    $filterCategory = $_GET['nivel'] ?? '';

    $sqlCats = "SELECT * FROM categories";
    $paramsCats = [];
    if ($filterCategory !== '') {
        $sqlCats .= " WHERE name = :catname";
        $paramsCats[':catname'] = $filterCategory;
    }
    $sqlCats .= " ORDER BY name ASC";
    $stmtCats = $pdo->prepare($sqlCats);
    $stmtCats->execute($paramsCats);
    $categories = $stmtCats->fetchAll(PDO::FETCH_ASSOC);

    if (!$categories) {
        echo '<div class="schools-empty"><i class="fa-solid fa-school"></i> No hay categorías ni escuelas registradas.</div>';
    } else {
        foreach ($categories as $cat) {
            $catNameEsc = htmlspecialchars($cat['name']);
            $catIdEsc = (int)$cat['id'];
            echo '<h3 class="title-container mt-4 d-flex align-items-center justify-content-between">';
            echo '<span>' . $catNameEsc . '</span>';

            $hideBtnsClass = ($catIdEsc === 7) ? ' d-none' : '';

            echo '<span class="' . $hideBtnsClass . '">';
            echo '<button type="button" class="btn btn-sm btn-primary me-1" 
                          data-bs-toggle="modal" data-bs-target="#modalModifyCategory" 
                          data-category-id="' . $catIdEsc . '" 
                          data-category-name="' . $catNameEsc . '" 
                          title="Modificar categoría">
                    <i class="fa fa-edit"></i>
                  </button>';

            echo '<button type="button" class="btn btn-sm btn-danger" 
                          data-bs-toggle="modal" data-bs-target="#modalDeleteCategory" 
                          data-category-id="' . $catIdEsc . '" 
                          data-category-name="' . $catNameEsc . '" 
                          title="Eliminar categoría">
                    <i class="fa fa-trash"></i>
                  </button>';
            echo '</span>';

            echo '</h3>';

            $sqlSchools = "SELECT * FROM schools WHERE category_id = :catid";
            $paramsSchools = [':catid' => $catIdEsc];

            if (!empty($_GET['nombre'])) {
                $sqlSchools .= " AND service_code LIKE :nombre";
                $paramsSchools[':nombre'] = '%' . $_GET['nombre'] . '%';
            }
            if (!empty($_GET['cue'])) {
                $sqlSchools .= " AND cue_code LIKE :cue";
                $paramsSchools[':cue'] = '%' . $_GET['cue'] . '%';
            }

            $sqlSchools .= " ORDER BY service_code ASC";
            $stmtSchools = $pdo->prepare($sqlSchools);
            $stmtSchools->execute($paramsSchools);
            $schools = $stmtSchools->fetchAll(PDO::FETCH_ASSOC);

            if (count($schools) === 0) {
                echo '<div class="schools-empty">No hay escuelas registradas en esta categoría.</div>';
            } else {
                // Agregamos id único al checkbox selectAll y clase con id de categoría a checkboxes
                echo '<table class="table table-styles table-striped table-hover align-middle">';
                echo '<thead>
                        <tr>
                          <th><input type="checkbox" class="selectAllCategory" data-cat-id="' . $catIdEsc . '" id="selectAll_' . $catIdEsc . '"></th>
                          <th>ID</th>
                          <th>Nombre</th>
                          <th>Turno</th>
                          <th>Edificio Compartido</th>
                          <th>CUE</th>
                          <th>Dirección</th>
                          <th>Localidad</th>
                          <th>Teléfono</th>
                          <th>Email</th>
                          <th>Director/a</th>
                          <th>Vicedirector/a</th>
      
                          <th class="action-btns">Acciones</th>
                        </tr>
                      </thead>
                      <tbody>';

                foreach ($schools as $s) {
                    $stmtAuth = $pdo->prepare("SELECT id, role, name, school_id, personal_phone, personal_email FROM authorities WHERE school_id = :school_id");
                    $stmtAuth->execute([':school_id' => $s['id']]);
                    $authorities = $stmtAuth->fetchAll(PDO::FETCH_ASSOC);

                    $director = $viceDirector = $secretary = '';

                    foreach ($authorities as $auth) {
                        $role = strtolower($auth['role']);
                        if (strpos($role, 'director/a') !== false && $director === '') {
                            $director = htmlspecialchars($auth['name']);
                        } elseif ((strpos($role, 'vicedirector/a') !== false || strpos($role, 'vicedirector/a') !== false) && $viceDirector === '') {
                            $viceDirector = htmlspecialchars($auth['name']);
                        } elseif (strpos($role, 'secretario/a') !== false && $secretary === '') {
                            $secretary = htmlspecialchars($auth['name']);
                        }
                    }

                    $escuelaJSON = htmlspecialchars(json_encode($s, JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8');
                    $autoridadesJSON = htmlspecialchars(json_encode($authorities, JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8');

                    // Agregamos clase con categoría para filtrar checkboxes
                    echo '<tr>
                            <td><input type="checkbox" name="ids[]" value="' . htmlspecialchars($s['id']) . '" class="checkboxCat_' . $catIdEsc . '"></td>
                            <td>' . htmlspecialchars($s['id']) . '</td>
                            <td>' . htmlspecialchars($s['service_code']) . '</td>
                            <td>' . htmlspecialchars($s['shift']) . '</td>
                            <td>' . htmlspecialchars($s['shared_building']) . '</td>
                            <td>' . htmlspecialchars($s['cue_code']) . '</td>
                            <td>' . htmlspecialchars($s['address']) . '</td>
                            <td>' . htmlspecialchars($s['locality']) . '</td>
                            <td>' . htmlspecialchars($s['phone']) . '</td>
                            <td>' . htmlspecialchars($s['email']) . '</td>
                            <td>' . $director . '</td>
                            <td>' . $viceDirector . '</td>

                            <td class="action-btns">
                              <button type="button" class="btn btn-sm btn-primary me-1 mb-1"
                                data-bs-toggle="modal" data-bs-target="#modalShowModify"
                                data-school=\'' . $escuelaJSON . '\'
                                data-authorities=\'' . $autoridadesJSON . '\'
                              >
                                <i class="fa fa-edit"></i>
                              </button>
                              <button type="button" class="btn btn-sm btn-danger mb-1"
                                data-bs-toggle="modal" data-bs-target="#modalShowDelete"
                                data-school=\'' . $escuelaJSON . '\'
                                data-authorities=\'' . $autoridadesJSON . '\'
                              >
                                <i class="fa fa-trash"></i>
                              </button>
                              <a href="create_folder_and_redirect.php?id=' . $s['id'] . '" class="btn btn-sm btn-secondary mb-1" title="Archivos">
                                <i class="fa fa-file"></i>
                              </a>
                            </td>
                          </tr>';
                }
                echo '</tbody></table>';
            }
        }
    }
    ?>

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

    // Evento para abrir modal mostrar y cargar datos escuela + autoridades
    var showModifyModal = document.getElementById('modalShowModify');
    if (showModifyModal) {
      showModifyModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        var schoolData = button.getAttribute('data-school');
        var authoritiesData = button.getAttribute('data-authorities');

        var school = {};
        var authorities = [];

        try {
          school = JSON.parse(schoolData);
        } catch (e) {
          school = {};
        }

        try {
          authorities = JSON.parse(authoritiesData);
        } catch (e) {
          authorities = [];
        }

        // Mostrar datos de la escuela (todos los campos)
        document.getElementById('show-mod-school-id').textContent = school.id || '';
        document.getElementById('show-mod-school-name').textContent = school.schoolName || '';
        document.getElementById('show-mod-school-category').textContent = school.category_name || school.category_id || '';
        document.getElementById('show-mod-school-is_disadvantaged').textContent = school.is_disadvantaged == 1 ? 'Sí' : 'No';
        document.getElementById('show-mod-school-shift').textContent = school.shift || '';
        document.getElementById('show-mod-school-service_code').textContent = school.service_code || '';
        document.getElementById('show-mod-school-shared_building').textContent = school.shared_building || '';
        document.getElementById('show-mod-school-cue_code').textContent = school.cue_code || '';
        document.getElementById('show-mod-school-address').textContent = school.address || '';
        document.getElementById('show-mod-school-locality').textContent = school.locality || '';
        document.getElementById('show-mod-school-phone').textContent = school.phone || '';
        document.getElementById('show-mod-school-email').textContent = school.email || '';
        document.getElementById('show-mod-school-created_at').textContent = school.created_at || '';
        document.getElementById('show-mod-school-updated_at').textContent = school.updated_at || '';

        // Pasar datos para modificar escuela al botón
        var btnModSchool = document.getElementById('btn-modify-school');
        btnModSchool.dataset.school = schoolData;

        // Construir lista de autoridades
        var authList = document.getElementById('show-mod-authorities-list');
        authList.innerHTML = '';

        if (authorities.length === 0) {
          authList.innerHTML = '<p class="text-muted">No hay autoridades asociadas.</p>';
        } else {
          authorities.forEach(function (auth) {
            // Crear contenedor para autoridad
            var div = document.createElement('div');
            div.classList.add('d-flex', 'align-items-center', 'justify-content-between', 'mb-2');

            // Texto autoridad: rol y nombre
            var span = document.createElement('span');
            span.textContent = auth.role + ': ' + auth.name;

            // Botón modificar autoridad
            var btn = document.createElement('button');
            btn.className = 'btn btn-sm btn-primary btn-modify-authority';
            btn.textContent = 'Modificar';

            // Guardar datos authority y school para pasarlos al modal modificar autoridad
            btn.dataset.authority = JSON.stringify(auth);
            btn.dataset.school = schoolData;

            // Atributos bootstrap modal
            btn.setAttribute('data-bs-toggle', 'modal');
            btn.setAttribute('data-bs-target', '#modalModifyAuthority');

            // Añadir texto y botón al div
            div.appendChild(span);
            div.appendChild(btn);

            // Añadir div a la lista de autoridades
            authList.appendChild(div);
          });
        }
      });
    }

  });

    // Abrir modal modificar escuela y cargar datos al botón modificar escuela
    document.getElementById('btn-modify-school').addEventListener('click', function () {
      var schoolData = this.dataset.school;
      var school = {};
      try {
        school = JSON.parse(schoolData);
      } catch (e) {
        school = {};
      }

      var editModal = new bootstrap.Modal(document.getElementById('modalModifySchool'));

      document.getElementById('edit-id').value = school.id || '';
      document.getElementById('edit-schoolName').value = school.schoolName || '';
      document.getElementById('edit-category_id').value = school.category_id || '';
      document.getElementById('edit-is_disadvantaged').value = school.is_disadvantaged ? '1' : '0';
      document.getElementById('edit-shift').value = school.shift || '';
      document.getElementById('edit-service_code').value = school.service_code || '';
      document.getElementById('edit-shared_building').value = school.shared_building || '';
      document.getElementById('edit-cue_code').value = school.cue_code || '';
      document.getElementById('edit-address').value = school.address || '';
      document.getElementById('edit-locality').value = school.locality || '';
      document.getElementById('edit-phone').value = school.phone || '';
      document.getElementById('edit-email').value = school.email || '';
      editModal.show();

      // Cerrar modal mostrar
      var showModModal = bootstrap.Modal.getInstance(document.getElementById('modalShowModify'));
      if (showModModal) showModModal.hide();
    });

    // Abrir modal modificar autoridad con datos precargados
    document.getElementById('modalShowModify').addEventListener('click', function (e) {
      if (e.target && e.target.classList.contains('btn-modify-authority')) {
        var authData = e.target.dataset.authority;
        var auth = {};
        try {
          auth = JSON.parse(authData);
        } catch (e) {
          auth = {};
        }

        var modAuthModal = new bootstrap.Modal(document.getElementById('modalModifyAuthority'));

        document.getElementById('mod-auth-id').value = auth.id || '';
        document.getElementById('mod-auth-name').value = auth.name || '';
        document.getElementById('mod-auth-role').value = auth.role || '';
        document.getElementById('mod-auth-school_id').value = auth.school_id || '';
        document.getElementById('mod-auth-phone').value = auth.personal_phone || '';
        document.getElementById('mod-auth-email').value = auth.personal_email || '';

        modAuthModal.show();

        // Cerrar modal mostrar
        var showModModal = bootstrap.Modal.getInstance(document.getElementById('modalShowModify'));
        if (showModModal) showModModal.hide();
      }
    });

  //OPCIONES PARA ELIMINACIÓN

  // Modal mostrar para eliminar escuela + autoridades
  var showDeleteModal = document.getElementById('modalShowDelete');
  if (showDeleteModal) {
    showDeleteModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var schoolData = button.getAttribute('data-school');
      var authoritiesData = button.getAttribute('data-authorities');

      var school = {};
      var authorities = [];

      try {
        school = JSON.parse(schoolData);
      } catch(e) { school = {}; }

      try {
        authorities = JSON.parse(authoritiesData);
      } catch(e) { authorities = []; }

      document.getElementById('show-del-school-name').textContent = school.service_code || '';
      document.getElementById('show-del-school-cue').textContent = school.cue_code || '';

      var authList = document.getElementById('show-del-authorities-list');
      authList.innerHTML = '';
      if(authorities.length === 0){
        authList.innerHTML = '<p class="text-muted">No hay autoridades asociadas.</p>';
      } else {
        authorities.forEach(function(auth){
          var div = document.createElement('div');
          div.classList.add('d-flex', 'align-items-center', 'justify-content-between', 'mb-2');

          var span = document.createElement('span');
          span.textContent = auth.role + ': ' + auth.name;

          var btn = document.createElement('button');
          btn.className = 'btn btn-sm btn-danger btn-delete-authority';
          btn.textContent = 'Eliminar';
          btn.dataset.authority = JSON.stringify(auth);
          btn.setAttribute('data-bs-toggle', 'modal');
          btn.setAttribute('data-bs-target', '#modalDeleteAuthority');

          div.appendChild(span);
          div.appendChild(btn);
          authList.appendChild(div);
        });
      }

      // Botón eliminar escuela
      var btnDelSchool = document.getElementById('btn-delete-school');
      btnDelSchool.dataset.school = schoolData;
    });
  }

  // Al clicar botón eliminar escuela desde modal mostrar eliminar
  document.getElementById('btn-delete-school').addEventListener('click', function() {
      var schoolData = this.dataset.school;
      var school = {};
      try {
        school = JSON.parse(schoolData);
      } catch(e) { school = {}; }

      document.getElementById('del-school-id').value = school.id || '';
      document.getElementById('del-school-name').textContent = school.service_code || '';

      var delSchoolModal = new bootstrap.Modal(document.getElementById('modalDeleteSchool'));
      delSchoolModal.show();

      var showDelModal = bootstrap.Modal.getInstance(document.getElementById('modalShowDelete'));
      if(showDelModal) showDelModal.hide();
  });


  // Al clicar botón eliminar autoridad desde modal mostrar eliminar
  document.querySelector('#modalShowDelete').addEventListener('click', function(e){
    if(e.target && e.target.classList.contains('btn-delete-authority')){
      var authData = e.target.dataset.authority;
      var auth = {};
      try { auth = JSON.parse(authData); } catch(e) { auth = {}; }

      var delAuthModal = new bootstrap.Modal(document.getElementById('modalDeleteAuthority'));

      document.getElementById('del-auth-id').value = auth.id || '';
      document.getElementById('del-auth-name').textContent = auth.name || '';

      delAuthModal.show();

      // Cerrar modal mostrar eliminar
      var showDelModal = bootstrap.Modal.getInstance(document.getElementById('modalShowDelete'));
      if(showDelModal) showDelModal.hide();
    }
  });

  document.addEventListener('DOMContentLoaded', () => {
  const modifyModal = document.getElementById('modalModifyCategory');
  const deleteModal = document.getElementById('modalDeleteCategory');

  // Rellenar modal modificar al abrir
  modifyModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-category-id');
    const name = button.getAttribute('data-category-name');

    document.getElementById('modifyCategoryId').value = id;
    document.getElementById('modifyCategoryName').value = name;
    document.getElementById('modifyCategoryDescription').value = ''; // Opcional, si quieres traer descripción real, tendrás que hacer fetch aparte

    document.getElementById('modifyCategoryFeedback').textContent = '';
  });

  // Rellenar modal eliminar al abrir
  deleteModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-category-id');
    const name = button.getAttribute('data-category-name');

    document.getElementById('deleteCategoryId').value = id;
    document.getElementById('deleteCategoryName').textContent = name;
    document.getElementById('deleteCategoryFeedback').textContent = '';
  });

  // Enviar formulario modificar
  document.getElementById('formModifyCategory').addEventListener('submit', async e => {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const feedback = document.getElementById('modifyCategoryFeedback');

    try {
      const res = await fetch('category_update.php', {
        method: 'POST',
        body: formData
      });
      const data = await res.json();

      if (res.ok && data.success) {
        feedback.style.color = 'green';
        feedback.textContent = data.message;
        // Recargar página para ver cambios o actualizar UI dinámicamente
        setTimeout(() => location.reload(), 1000);
      } else {
        feedback.style.color = 'red';
        feedback.textContent = data.error || 'Error al modificar la categoría';
      }
    } catch (error) {
      feedback.style.color = 'red';
      feedback.textContent = 'Error de conexión';
    }
  });

  // Enviar formulario eliminar
  document.getElementById('formDeleteCategory').addEventListener('submit', async e => {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const feedback = document.getElementById('deleteCategoryFeedback');

    try {
      const res = await fetch('category_delete.php', {
        method: 'POST',
        body: formData
      });
      const data = await res.json();

      if (res.ok && data.success) {
        feedback.style.color = 'green';
        feedback.textContent = data.message;
        // Recargar página para ver cambios o actualizar UI dinámicamente
        setTimeout(() => location.reload(), 1000);
      } else {
        feedback.style.color = 'red';
        feedback.textContent = data.error || 'Error al eliminar la categoría';
      }
    } catch (error) {
      feedback.style.color = 'red';
      feedback.textContent = 'Error de conexión';
    }
  });
});

  document.querySelectorAll('.selectAllCategory').forEach(selectAllCheckbox => {
    selectAllCheckbox.addEventListener('change', function() {
      const catId = this.getAttribute('data-cat-id');
      const checkboxes = document.querySelectorAll('.checkboxCat_' + catId);
      checkboxes.forEach(cb => cb.checked = this.checked);
    });
  });


</script>

</body>
</html>
