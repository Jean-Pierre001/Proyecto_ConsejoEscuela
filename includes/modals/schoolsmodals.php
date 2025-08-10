<!-- Modal Agregar Escuela -->
<div class="modal fade" id="modalAddSchool" tabindex="-1" aria-labelledby="modalAddSchoolLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="post" action="school_add.php">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="modalAddSchoolLabel"><i class="fa fa-plus"></i> Agregar Escuela</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nombre</label>
              <input type="text" name="schoolName" class="form-control" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">CUE</label>
              <input type="text" name="cue" class="form-control">
            </div>
            <div class="col-md-3">
              <label class="form-label">Turno</label>
              <select name="shift" class="form-select">
                <option value="">--</option>
                <option value="manana">Mañana</option>
                <option value="tarde">Tarde</option>
                <option value="noche">Noche</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Dirección</label>
              <input type="text" name="address" class="form-control">
            </div>
            <div class="col-md-3">
              <label class="form-label">Ciudad</label>
              <input type="text" name="city" class="form-control">
            </div>
            <div class="col-md-3">
              <label class="form-label">Teléfono</label>
              <input type="text" name="phone" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="form-label">Director/a</label>
              <input type="text" name="principal" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="form-label">Vicedirector/a</label>
              <input type="text" name="vicePrincipal" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="form-label">Secretario/a</label>
              <input type="text" name="secretary" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Nivel / Servicio</label>
              <input type="text" name="service" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">¿Comparte edificio?</label>
              <select name="sharedBuilding" class="form-select">
                <option value="">--</option>
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
            </div>
            <div class="col-md-12">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Mostrar para Modificar -->
<div class="modal fade" id="modalShowModify" tabindex="-1" aria-labelledby="modalShowModifyLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalShowModifyLabel">Detalles de la Escuela y Autoridades (Modificar)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <h5>Escuela</h5>
        <ul class="list-group mb-3">
          <li class="list-group-item"><strong>Nombre / Código:</strong> <span id="show-mod-school-name"></span></li>
          <li class="list-group-item"><strong>CUE:</strong> <span id="show-mod-school-cue"></span></li>
          <li class="list-group-item"><strong>Turno:</strong> <span id="show-mod-school-shift"></span></li>
          <li class="list-group-item"><strong>Dirección:</strong> <span id="show-mod-school-address"></span></li>
          <li class="list-group-item"><strong>Localidad:</strong> <span id="show-mod-school-locality"></span></li>
          <li class="list-group-item"><strong>Teléfono:</strong> <span id="show-mod-school-phone"></span></li>
          <li class="list-group-item"><strong>Email:</strong> <span id="show-mod-school-email"></span></li>
          <li class="list-group-item"><strong>Edificio Compartido:</strong> <span id="show-mod-school-shared"></span></li>
        </ul>
        <button id="btn-modify-school" class="btn btn-primary mb-4">Modificar Escuela</button>

        <h5>Autoridades</h5>
        <div id="show-mod-authorities-list"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Modificar Escuela -->
<div class="modal fade" id="modalModifySchool" tabindex="-1" aria-labelledby="modalModifySchoolLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="post" action="schools_edit.php" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalModifySchoolLabel">Modificar Escuela</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="edit-id" name="id">

        <div class="mb-3">
          <label for="edit-service_code" class="form-label">Nombre / Código</label>
          <input type="text" id="edit-service_code" name="service_code" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="edit-shift" class="form-label">Turno</label>
          <input type="text" id="edit-shift" name="shift" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="edit-cue_code" class="form-label">CUE</label>
          <input type="text" id="edit-cue_code" name="cue_code" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="edit-address" class="form-label">Dirección</label>
          <input type="text" id="edit-address" name="address" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="edit-locality" class="form-label">Localidad</label>
          <input type="text" id="edit-locality" name="locality" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="edit-phone" class="form-label">Teléfono</label>
          <input type="text" id="edit-phone" name="phone" class="form-control">
        </div>

        <div class="mb-3">
          <label for="edit-email" class="form-label">Email</label>
          <input type="email" id="edit-email" name="email" class="form-control">
        </div>

        <div class="mb-3">
          <label for="edit-shared_building" class="form-label">Edificio Compartido</label>
          <select id="edit-shared_building" name="shared_building" class="form-select" required>
            <option value="1">Sí</option>
            <option value="0">No</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="edit-category_id" class="form-label">Categoría</label>
          <select id="edit-category_id" name="category_id" class="form-select" required>
            <option value="">Seleccione categoría</option>
            <?php
            // Cargar categorías para el select
            $cats = $pdo->query("SELECT id, name FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
            foreach($cats as $c){
              echo '<option value="'.htmlspecialchars($c['id']).'">'.htmlspecialchars($c['name']).'</option>';
            }
            ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="update" class="btn btn-primary">Guardar Cambios</button>
        <button type="submit" name="delete_school" class="btn btn-danger" onclick="return confirm('¿Seguro que querés eliminar esta escuela? Esta acción es irreversible.')">Eliminar Escuela</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>


<!-- Modal Modificar Autoridad -->
<div class="modal fade" id="modalModifyAuthority" tabindex="-1" aria-labelledby="modalModifyAuthorityLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="authorities_edit.php" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalModifyAuthorityLabel">Modificar Autoridad</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <!-- Campo oculto para ID -->
        <input type="hidden" id="mod-auth-id" name="id">

        <!-- Nombre -->
        <div class="mb-3">
          <label for="mod-auth-name" class="form-label">Nombre</label>
          <input type="text" id="mod-auth-name" name="name" class="form-control" required>
        </div>

        <!-- Rol -->
        <div class="mb-3">
          <label for="mod-auth-role" class="form-label">Rol</label>
          <input type="text" id="mod-auth-role" name="role" class="form-control" placeholder="Ej: Director/a" required>
        </div>

        <!-- Escuela -->
        <div class="mb-3">
          <label for="mod-auth-school_id" class="form-label">Escuela</label>
          <select id="mod-auth-school_id" name="school_id" class="form-select" required>
            <option value="">Seleccione una escuela</option>
            <?php
            // Listar escuelas para select
            $schools = $pdo->query("SELECT id, service_code FROM schools ORDER BY service_code ASC")->fetchAll(PDO::FETCH_ASSOC);
            foreach($schools as $sch){
              echo '<option value="'.htmlspecialchars($sch['id']).'">'.htmlspecialchars($sch['service_code']).'</option>';
            }
            ?>
          </select>
        </div>

        <!-- Teléfono personal -->
        <div class="mb-3">
          <label for="mod-auth-phone" class="form-label">Teléfono personal</label>
          <input type="text" id="mod-auth-phone" name="personal_phone" class="form-control" placeholder="Opcional">
        </div>

        <!-- Email personal -->
        <div class="mb-3">
          <label for="mod-auth-email" class="form-label">Email personal</label>
          <input type="email" id="mod-auth-email" name="personal_email" class="form-control" placeholder="Opcional">
        </div>
      </div>

      <div class="modal-footer">
        <button type="submit" name="update" class="btn btn-primary">Guardar Cambios</button>
        <button type="submit" name="delete_authority" class="btn btn-danger" onclick="return confirm('¿Seguro que querés eliminar esta autoridad? Esta acción es irreversible.')">Eliminar Autoridad</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>



<!-- Modal Mostrar para Eliminar -->
<div class="modal fade" id="modalShowDelete" tabindex="-1" aria-labelledby="modalShowDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalShowDeleteLabel">Detalles de la Escuela y Autoridades (Eliminar)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <h5>Escuela</h5>
        <ul class="list-group mb-3">
          <li class="list-group-item"><strong>Nombre / Código:</strong> <span id="show-del-school-name"></span></li>
          <li class="list-group-item"><strong>CUE:</strong> <span id="show-del-school-cue"></span></li>
        </ul>
        <button id="btn-delete-school" class="btn btn-danger mb-4">Eliminar Escuela</button>

        <h5>Autoridades</h5>
        <div id="show-del-authorities-list"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Eliminar Escuela -->
<div class="modal fade" id="modalDeleteSchool" tabindex="-1" aria-labelledby="modalDeleteSchoolLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="schools_delete.php" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDeleteSchoolLabel">Eliminar Escuela</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="del-school-id" name="id">
        <p>¿Estás seguro que querés eliminar la escuela <strong id="del-school-name"></strong>?</p>
        <p class="text-danger">Esta acción es irreversible.</p>
      </div>
      <div class="modal-footer">
        <button type="submit" name="delete" class="btn btn-danger">Eliminar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Eliminar Autoridad -->
<div class="modal fade" id="modalDeleteAuthority" tabindex="-1" aria-labelledby="modalDeleteAuthorityLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="authorities_delete.php" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDeleteAuthorityLabel">Eliminar Autoridad</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="del-auth-id" name="id">
        <p>¿Estás seguro que querés eliminar la autoridad <strong id="del-auth-name"></strong>?</p>
        <p class="text-danger">Esta acción es irreversible.</p>
      </div>
      <div class="modal-footer">
        <button type="submit" name="delete" class="btn btn-danger">Eliminar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Agregar Categoría -->
<div class="modal fade" id="modalAddCategory" tabindex="-1" aria-labelledby="modalAddCategoryLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="categories_add.php" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddCategoryLabel">Agregar Categoría</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="new-category-name" class="form-label">Nombre de la Categoría</label>
          <input type="text" id="new-category-name" name="name" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="add" class="btn btn-success">Agregar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Agregar Autoridad -->
<div class="modal fade" id="modalAddAuthority" tabindex="-1" aria-labelledby="modalAddAuthorityLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="authorities_add.php" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAddAuthorityLabel">Agregar Autoridad</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="new-auth-name" class="form-label">Nombre</label>
          <input type="text" id="new-auth-name" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="new-auth-role" class="form-label">Rol</label>
          <input type="text" id="new-auth-role" name="role" class="form-control" placeholder="Ej: Director/a" required>
        </div>
        <div class="mb-3">
          <label for="new-auth-school_id" class="form-label">Escuela</label>
          <select id="new-auth-school_id" name="school_id" class="form-select" required>
            <option value="">Seleccione una escuela</option>
            <?php
            $schools = $pdo->query("SELECT id, service_code FROM schools ORDER BY service_code ASC")->fetchAll(PDO::FETCH_ASSOC);
            foreach($schools as $sch){
              echo '<option value="'.htmlspecialchars($sch['id']).'">'.htmlspecialchars($sch['service_code']).'</option>';
            }
            ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="add" class="btn btn-success">Agregar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>
