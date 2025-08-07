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

<!-- Modal Editar Escuela -->
<div class="modal fade" id="modalEditSchool" tabindex="-1" aria-labelledby="modalEditSchoolLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="post" action="school_edit.php">
      <input type="hidden" name="id" id="edit-id">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalEditSchoolLabel"><i class="fa fa-edit"></i> Editar Escuela</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nombre</label>
              <input type="text" name="schoolName" id="edit-schoolName" class="form-control" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">CUE</label>
              <input type="text" name="cue" id="edit-cue" class="form-control">
            </div>
            <div class="col-md-3">
              <label class="form-label">Turno</label>
              <select name="shift" id="edit-shift" class="form-select">
                <option value="">--</option>
                <option value="manana">Mañana</option>
                <option value="tarde">Tarde</option>
                <option value="noche">Noche</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Dirección</label>
              <input type="text" name="address" id="edit-address" class="form-control">
            </div>
            <div class="col-md-3">
              <label class="form-label">Ciudad</label>
              <input type="text" name="city" id="edit-city" class="form-control">
            </div>
            <div class="col-md-3">
              <label class="form-label">Teléfono</label>
              <input type="text" name="phone" id="edit-phone" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="form-label">Director/a</label>
              <input type="text" name="principal" id="edit-principal" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="form-label">Vicedirector/a</label>
              <input type="text" name="vicePrincipal" id="edit-vicePrincipal" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="form-label">Secretario/a</label>
              <input type="text" name="secretary" id="edit-secretary" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Nivel / Servicio</label>
              <input type="text" name="service" id="edit-service" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">¿Comparte edificio?</label>
              <select name="sharedBuilding" id="edit-sharedBuilding" class="form-select">
                <option value="">--</option>
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
            </div>
            <div class="col-md-12">
              <label class="form-label">Email</label>
              <input type="email" name="email" id="edit-email" class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar cambios</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>
