<!-- Modal Agregar Inspector -->
<div class="modal fade" id="modalAddInspector" tabindex="-1" aria-labelledby="modalAddInspectorLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="post" action="inspectors_back/inspector_add.php">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="modalAddInspectorLabel">
            <i class="fa fa-plus"></i> Agregar Inspector
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nombre</label>
              <input type="text" name="name" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Modalidad/Nivel</label>
              <input type="text" name="levelModality" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Teléfono</label>
              <input type="text" name="phone" class="form-control">
            </div>

            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control">
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

<!-- Modal Eliminar Inspector -->
<div class="modal fade" id="modalDeleteInspector" tabindex="-1" aria-labelledby="modalDeleteInspectorLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="inspectors_back/inspector_delete.php">
      <input type="hidden" name="id" id="deleteInspectorId">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="modalDeleteInspectorLabel">
            <i class="fa fa-trash"></i> Eliminar Inspector
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>¿Estás seguro que deseas eliminar al inspector <strong id="deleteInspectorName"></strong>?</p>
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

<!-- Modal Editar Inspector -->
<div class="modal fade" id="modalEditInspector" tabindex="-1" aria-labelledby="modalEditInspectorLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="post" action="inspectors_back/inspector_edit.php">
      <input type="hidden" name="id" id="editInspectorId">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalEditInspectorLabel">
            <i class="fa fa-edit"></i> Editar Inspector
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nombre</label>
              <input type="text" name="name" id="editInspectorName" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Modalidad/Nivel</label>
              <input type="text" name="levelModality" id="editInspectorLevel" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Teléfono</label>
              <input type="text" name="phone" id="editInspectorPhone" class="form-control">
            </div>

            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="email" id="editInspectorEmail" class="form-control">
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

