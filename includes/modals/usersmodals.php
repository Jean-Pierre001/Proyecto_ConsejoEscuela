<!-- Modal Agregar Usuario -->
<div class="modal fade" id="modalAddUser" tabindex="-1" aria-labelledby="modalAddUserLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="post" action="users_back/user_add.php">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="modalAddUserLabel">
            <i class="fa fa-plus"></i> Agregar Usuario
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Usuario</label>
              <input type="text" name="username" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Rol</label>
              <select name="role" class="form-select" required>
                <option value="Usuario" selected>Usuario</option>
                <option value="Administrador">Administrador</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Contraseña</label>
              <input type="password" name="password" class="form-control" required minlength="6">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">
            <i class="fa fa-save"></i> Guardar
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Eliminar Usuario -->
<div class="modal fade" id="modalDeleteUser" tabindex="-1" aria-labelledby="modalDeleteUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="users_back/user_delete.php">
      <input type="hidden" name="id" id="deleteUserId">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="modalDeleteUserLabel">
            <i class="fa fa-trash"></i> Eliminar Usuario
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>¿Estás seguro que deseas eliminar al usuario <strong id="deleteUserName"></strong>?</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">
            <i class="fa fa-trash"></i> Eliminar
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Editar Usuario -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="post" action="users_back/user_edit.php">
      <input type="hidden" name="id" id="editUserId">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalEditUserLabel">
            <i class="fa fa-edit"></i> Editar Usuario
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Usuario</label>
              <input type="text" name="username" id="editUserName" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="email" id="editUserEmail" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Rol</label>
              <select name="role" id="editUserRole" class="form-select" required>
                <option value="Usuario">Usuario</option>
                <option value="Administrador">Administrador</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Nueva Contraseña (dejar en blanco para no cambiar)</label>
              <input type="password" name="password" class="form-control" minlength="6" placeholder="********">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Guardar cambios
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>
