<?php
include 'includes/session.php';
include 'includes/conn.php';
include 'includes/modals/indexmodals.php';

?>
<!DOCTYPE html>
<html lang="es">
<?php $pageTitle = 'Gestor de Archivos'; include 'includes/header.php'; ?>
<style>
  body, html { height: 100%; margin: 0; }
  .d-flex { height: 100vh; overflow: hidden; }
  .dropzone { border: 2px dashed #007bff; border-radius: 6px; background: #f8f9fa; padding: 50px; }
  .folder-item:hover, .file-row:hover { background-color: #e9ecef; cursor: pointer; }
  .breadcrumb-item a { text-decoration: none; }
  .action-buttons button { margin-right: 0.3rem; }
    .selected-filename {
  color: blue !important;
  font-weight: bold;
}
.folder-item {
  height: 48px !important;         /* Fuerza una altura exacta */
  line-height: 28px !important;    /* Centra verticalmente el contenido */
  padding-top: 0 !important;
  padding-bottom: 0 !important;
  font-size: 15px;                 /* Opcional: más chico para que entre mejor */
}
.folder-item span {
  flex-grow: 1;                    /* Permite que el texto ocupe el espacio disponible */
  overflow: hidden;                /* Oculta el desbordamiento */
  text-overflow: ellipsis;         /* Agrega puntos suspensivos al final si es necesario */
  white-space: nowrap;             /* Evita que el texto se divida en varias líneas */
}

</style>

  <!-- HABILITAR CUANDO YA ESTE HOSTEADO EN CASO CONTRARIO DA ERRORES INDESEADOS -->
<!--  <iframe src="https://view.officeapps.live.com/op/embed.aspx?src=URL_DEL_ARCHIVO" width="100%" height="600px" frameborder="0"></iframe> -->

<?php include 'includes/navbar.php'; ?>
<div class="d-flex">
  <?php include 'includes/sidebar.php'; ?>
  <main class="p-4 flex-grow-1 overflow-auto">
    <h3>Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?> 👋</h3>
    <nav aria-label="breadcrumb" class="mb-3">
      <ol id="breadcrumb-container" class="breadcrumb"></ol>
    </nav>
    <div class="mb-4">
      <form id="create-folder-form" style="display: inline-flex; gap: 0.5rem; align-items: center;">
        <input type="text" name="folder_name" class="form-control form-control-sm" placeholder="Nombre carpeta" required style="max-width: 200px;" />
        <button type="submit" class="btn btn-sm btn-success">Crear</button>
      </form>
    </div>
    <section class="mb-4">
      <h5>Subir archivos</h5>
      <form action="upload_files.php" class="dropzone" id="my-dropzone" enctype="multipart/form-data">
        <input type="hidden" name="targetFolder" value="" />
      </form>
    </section>
    <hr />
    <section class="mb-3">
      <h5>Carpetas</h5>
      <ul id="folder-list" class="list-group"></ul>
    </section>
    <hr>
    <section>
    <h5>Archivos
      <button id="delete-selected" class="btn btn-danger btn-sm ms-3" disabled>Eliminar seleccionados</button>
      <button id="download-selected" class="btn btn-primary btn-sm ms-1" disabled>Descargar seleccionados</button>
      <button id="copy-selected" class="btn btn-primary btn-sm ms-1" disabled>Copiar</button>
      <button id="cut-selected" class="btn btn-warning btn-sm ms-1" disabled>Cortar</button>
      <button id="paste-files" class="btn btn-success btn-sm ms-1" disabled>Pegar</button>
    </h5>
    <div id="file-filters" class="mb-3">
  <label>Tipo archivo:
    <select id="file-type-filter">
      <option value="all">Todos</option>
      <option value="image">Imágenes</option>
      <option value="application/pdf">PDF</option>
      <option value="text">Texto</option>
      <!-- agregar más si quieres -->
    </select>
  </label>
  <label class="ms-3">Ordenar fecha:
    <select id="file-date-order">
      <option value="desc">Más nuevo primero</option>
      <option value="asc">Más viejo primero</option>
    </select>
  </label>
</div>
    <div id="file-list"></div>
  </section>
  </main>
</div>
<?php include 'includes/footer.php'; ?>

<!-- Agrega jQuery antes que los demás -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

<script>
let currentFolder = '';

function normalizePath(path) {
  path = path.replace(/\/+/g, '/');   // elimina barras repetidas
  path = path.replace(/^\/+/, '');    // elimina slash al inicio
  path = path.replace(/\/+$/, '');    // elimina slash al final
  return path;
}

// Estado global para copiar/cortar
let clipboardFiles = [];
let clipboardAction = null; // 'copy' o 'cut'

function updateClipboardButtons() {
  document.getElementById('paste-files').disabled = clipboardFiles.length === 0;
}

// Obtener archivos seleccionados
function getSelectedFiles() {
  return Array.from(document.querySelectorAll('.file-checkbox:checked')).map(chk => chk.dataset.path);
}

// Copiar archivos seleccionados
document.getElementById('copy-selected').addEventListener('click', () => {
  clipboardFiles = getSelectedFiles();
  if (clipboardFiles.length === 0) return;
  clipboardAction = 'copy';
  updateClipboardButtons();
  toastr.info(`Copiado ${clipboardFiles.length} archivo(s) para pegar.`);
});

document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('file-type-filter')?.addEventListener('change', () => loadFolder(currentFolder));
  document.getElementById('file-date-order')?.addEventListener('change', () => loadFolder(currentFolder));
});

// Cortar archivos seleccionados
document.getElementById('cut-selected').addEventListener('click', () => {
  clipboardFiles = getSelectedFiles();
  if (clipboardFiles.length === 0) return;
  clipboardAction = 'cut';
  updateClipboardButtons();
  toastr.info(`Cortado ${clipboardFiles.length} archivo(s) para mover.`);
});

// Pegar archivos en carpeta actual
document.getElementById('paste-files').addEventListener('click', () => {
  if (clipboardFiles.length === 0 || !clipboardAction) return;

  fetch('paste_files.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({
      source: clipboardFiles,
      target: currentFolder,
      action: clipboardAction
    })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      if (data.warning) {
      toastr.warning(data.warning);
    } else {
      toastr.success(data.message || 'Operación completada');
    }
      clipboardFiles = [];
      clipboardAction = null;
      updateClipboardButtons();
      loadFolder(currentFolder);
    } else {
      toastr.error(data.error || 'Error al pegar archivos');
    }
  })
  .catch(() => toastr.error('Error en la petición'));
});


function loadFolder(folder) {
  // Leer filtros actuales (o valores por defecto)
  const typeFilter = document.getElementById('file-type-filter')?.value || 'all';
  const dateOrder = document.getElementById('file-date-order')?.value || 'desc';

  fetch('list_files.php?folder=' + encodeURIComponent(folder))
    .then(res => res.json())
    .then(data => {
      currentFolder = data.current_folder;

      // Breadcrumbs
      const breadcrumbContainer = document.getElementById('breadcrumb-container');
      breadcrumbContainer.innerHTML = data.breadcrumbs.map((crumb, idx) => {
        if (idx === data.breadcrumbs.length - 1) {
          return `<li class="breadcrumb-item active" aria-current="page">${crumb.name}</li>`;
        } else {
          return `<li class="breadcrumb-item"><a href="#" data-folder="${crumb.path}">${crumb.name}</a></li>`;
        }
      }).join('');

      // Carpetas
      const folderList = document.getElementById('folder-list');
      folderList.innerHTML = data.folders.length
        ? data.folders.map(f => `
          <li class="list-group-item folder-item d-flex justify-content-between align-items-center" data-folder="${f.name}">
            <span style="cursor:pointer">📁 ${f.name}</span>
            <div>
              <button class="btn btn-sm btn-primary rename-folder-btn me-1" data-folder="${f.name}">Renombrar</button>
              <button class="btn btn-sm btn-danger delete-folder-btn" data-folder="${f.name}" data-hascontent="${f.hasContent}">Eliminar</button>
            </div>
          </li>
        `).join('')
        : '<p>No hay carpetas.</p>';

      // Filtros - renderizar select si no existe
      if (!document.getElementById('file-filters')) {
        const filtersHtml = `
          <div id="file-filters" class="mb-3">
            <label>Tipo archivo:
              <select id="file-type-filter" class="form-select form-select-sm" style="width:auto; display:inline-block; margin-left:5px;">
                <option value="all">Todos</option>
                <option value="image">Imágenes</option>
                <option value="application/pdf">PDF</option>
                <option value="text">Texto</option>
              </select>
            </label>
            <label class="ms-3">Ordenar fecha:
              <select id="file-date-order" class="form-select form-select-sm" style="width:auto; display:inline-block; margin-left:5px;">
                <option value="desc">Más nuevo primero</option>
                <option value="asc">Más viejo primero</option>
              </select>
            </label>
          </div>
        `;
        // Insertar antes de la lista de archivos
        const fileList = document.getElementById('file-list');
        fileList.insertAdjacentHTML('beforebegin', filtersHtml);

        // Agregar listeners para recargar con filtro nuevo
        document.getElementById('file-type-filter').addEventListener('change', () => loadFolder(currentFolder));
        document.getElementById('file-date-order').addEventListener('change', () => loadFolder(currentFolder));

        // Setear valores a los filtros actuales
        document.getElementById('file-type-filter').value = typeFilter;
        document.getElementById('file-date-order').value = dateOrder;
      } else {
        // Si ya existe, actualizar los selects para mantener sincronizados
        document.getElementById('file-type-filter').value = typeFilter;
        document.getElementById('file-date-order').value = dateOrder;
      }

      // Filtrar archivos por tipo
      let filesFiltered = data.files;
      if (typeFilter !== 'all') {
        if (typeFilter === 'image') {
          filesFiltered = filesFiltered.filter(f => f.type.startsWith('image/'));
        } else {
          filesFiltered = filesFiltered.filter(f => f.type.includes(typeFilter));
        }
      }

      // Ordenar archivos por fecha uploaded_at
      filesFiltered.sort((a, b) => {
        const dateA = new Date(a.uploaded_at);
        const dateB = new Date(b.uploaded_at);
        if (dateOrder === 'asc') {
          return dateA - dateB;
        } else {
          return dateB - dateA;
        }
      });

      // Mostrar archivos
      const fileList = document.getElementById('file-list');
      fileList.innerHTML = filesFiltered.length
        ? `<table class="table table-striped table-hover align-middle">
          <thead>
            <tr>
              <th><input type="checkbox" id="select-all-files" title="Seleccionar todos"></th>
              <th>Nombre</th><th>Tamaño</th><th>Fecha</th><th>Acciones</th>
            </tr>
          </thead><tbody>` +
          filesFiltered.map(file => `
            <tr class="file-row file-preview-row" data-path="${file.path}" data-type="${file.type}">
              <td><input type="checkbox" class="file-checkbox" data-path="${file.path}"></td>
              <td><span class="file-preview-link" data-path="${file.path}" data-type="${file.type}" style="color: inherit; text-decoration: none; cursor: pointer;">${file.filename}</span></td>
              <td>${(file.filesize / 1024).toFixed(2)} KB</td>
              <td>${file.uploaded_at}</td>
              <td class="action-buttons">
                <div class="dropdown">
                  <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Opciones
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="download_file.php?path=${encodeURIComponent(file.path)}">⬇️ Descargar</a></li>
                    <li><a class="dropdown-item" href="#" onclick="renameFile('${file.path}', '${file.filename}')">✏️ Renombrar</a></li>
                    <li><a class="dropdown-item" href="#" onclick="deleteFile('${file.path}')">🗑️ Eliminar</a></li>
                    <li><a class="dropdown-item" href="#" onclick="showProperties('${file.path}')">ℹ️ Propiedades</a></li>
                  </ul>
                </div>
              </td>
            </tr>
          `).join('') +
          `</tbody></table>`
        : '<p>No hay archivos.</p>';

      // Actualizar input hidden Dropzone (si existe)
      const targetFolderInput = document.querySelector('#my-dropzone input[name="targetFolder"]');
      if (targetFolderInput) targetFolderInput.value = currentFolder;

      // Click en carpetas para navegar SOLO si el click fue en el <span>
      document.querySelectorAll('.folder-item span').forEach(el => {
        el.addEventListener('click', (e) => {
          e.stopPropagation();
          const rawPath = (currentFolder ? currentFolder + '/' : '') + el.parentElement.dataset.folder;
          const newFolder = normalizePath(rawPath);
          loadFolder(newFolder);
        });
      });

      // Click en botón eliminar carpeta
      document.querySelectorAll('.delete-folder-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
          e.stopPropagation();
          const folderName = this.dataset.folder;
          const hasContent = this.dataset.hascontent === "true";
          const folderPath = (currentFolder ? currentFolder + '/' : '') + folderName;
          let msg = `¿Seguro que deseas eliminar la carpeta "${folderName}"?`;
          if (hasContent) {
            msg += "\nADVERTENCIA: La carpeta contiene archivos o subcarpetas y se eliminará todo su contenido.";
          }
          if (!confirm(msg)) return;
          fetch('delete_folder.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ path: folderPath })
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              toastr.success('Carpeta eliminada');
              loadFolder(currentFolder);
            } else {
              toastr.error(data.error || 'No se pudo eliminar la carpeta');
            }
          })
          .catch(() => toastr.error('Error al eliminar carpeta'));
        });
      });

      /*
      Problema principal de que no servia el renombrar carpeta para recordarlo
      El servidor estaba enviando una respuesta JSON pero junto con un mensaje de error (warning) en HTML que rompía la estructura del JSON.

      El mensaje era algo así:

      <br />
      <b>Warning</b>:  preg_match(): Unknown modifier ']' in rename_folder.php on line 17
      <br />
      {"success":true}
      Esto provoca que cuando tu código JavaScript intente hacer response.json(), falle porque el contenido no es JSON válido sino JSON + HTML.

      ¿Por qué apareció ese warning?
      Porque en el código PHP había un error a la hora de usar "preg_match():"

      preg_match('/[\\\/]/', $newName)
      Este patrón está mal escapado y PHP interpretó mal el modificador ], causando el warning.

      Cómo se solucionó
      Se corrigió el patrón a:

      preg_match('/[\\\\\\/]/', $newName)
      para que las barras invertidas y normales estén bien escapadas y la expresión sea válida.

      Se deshabilitaron los errores visibles de PHP con:

      php
      error_reporting(0);
      ini_set('display_errors', 0);
      para que en caso de que haya otros warnings no rompan la salida JSON.
      */

      // Click en botón renombrar carpeta
      document.querySelectorAll('.rename-folder-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
          e.stopPropagation();
          const oldName = this.dataset.folder;
          const oldPath = (currentFolder ? currentFolder + '/' : '') + oldName;
          const newName = prompt(`Nuevo nombre para la carpeta "${oldName}":`, oldName);
          if (!newName || newName.trim() === '' || newName === oldName) return;
          fetch('rename_folder.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ old_path: oldPath, new_name: newName.trim() })
          })
          .then(res => {
            if (!res.ok) throw new Error('Error HTTP ' + res.status);
            return res.json();
          })
          .then(data => {
            if (data.success) {
              toastr.success('Carpeta renombrada correctamente');
              // Aquí llamamos a loadFolder para actualizar automáticamente
              loadFolder(currentFolder);
            } else {
              toastr.error(data.error || 'Error al renombrar carpeta');
            }
          })
          .catch(err => {
            console.error('Fetch error:', err);
            toastr.error('Error al conectar con el servidor');
          });
        });
      });


      // Click en breadcrumb para navegar
      breadcrumbContainer.querySelectorAll('a').forEach(el => {
        el.addEventListener('click', e => {
          e.preventDefault();
          const rawPath = el.dataset.folder;
          const newFolder = normalizePath(rawPath);
          loadFolder(newFolder);  
        });
      });

    })
    .catch(() => toastr.error('Error al cargar contenido'));
}

function renameFile(path, filename) {
  document.getElementById('renamePath').value = path;
  document.getElementById('newNameInput').value = filename;

  // Mostrar el modal usando Bootstrap
  let modal = new bootstrap.Modal(document.getElementById('renameModal'));
  modal.show();
}

// Manejar el envío del formulario
document.getElementById('renameForm').addEventListener('submit', function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  fetch('rename_file.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      // Cerrar modal
      bootstrap.Modal.getInstance(document.getElementById('renameModal')).hide();
      toastr.success('Archivo renombrado correctamente');
      // Recargar o refrescar lista
      loadFolder(currentFolder);
    } else {
      alert('Error al renombrar: ' + (data.error || 'Desconocido'));
      toastr.error('Error al renombrar: ' + (data.error || 'Desconocido'));
    }
  })
  .catch(err => {
    console.error(err);
    toastr.error('error al pedir la petición al servidor');
  });
});

document.addEventListener('DOMContentLoaded', () => loadFolder(currentFolder));
// Cargar tabla de escuelas al iniciar
document.addEventListener('DOMContentLoaded', () => {
  loadFolder(currentFolder);
});

document.getElementById('create-folder-form').addEventListener('submit', function(e) {
  e.preventDefault();
  const name = this.folder_name.value.trim();
  if (!name) return toastr.warning('Nombre de carpeta requerido');
  fetch('create_folder.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({ folder_name: name, current_folder: currentFolder })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      toastr.success('Carpeta creada');
      this.folder_name.value = '';
      loadFolder(currentFolder);
    } else {
      toastr.error(data.error || 'Error al crear carpeta');
    }
  })
  .catch(() => toastr.error('Error al crear carpeta'));
});

// Configuración Dropzone
Dropzone.options.myDropzone = {
  paramName: "file",
  maxFilesize: 10,
  acceptedFiles: "image/*,application/pdf,text/plain,video/mp4,audio/mpeg",
  uploadMultiple: true,
  parallelUploads: 5,
  dictDefaultMessage: "Arrastra tus archivos aquí o haz clic para seleccionar",  
  previewsContainer: false,
  init: function () {
    this.on("sending", function (file, xhr, formData) {
      formData.append("targetFolder", currentFolder); 
    });
    this.on("successmultiple", function (files, response) {
      if (response.success) {
        toastr.success('Archivos subidos');
        loadFolder(currentFolder);
      } else if (response.error) {
        toastr.error(response.error);
      }
    });
    this.on("error", (file, response) =>
      toastr.error(typeof response === 'string' ? response : response.error || 'Error desconocido')
    );
  }
};

// Acciones

function deleteFile(path) {
  // Ya no pide confirmación, elimina directamente
  fetch('delete_file.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({ path })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      toastr.success('Archivo eliminado');
      loadFolder(currentFolder); // recarga solo la lista sin recargar toda la página
    } else {
      toastr.error(data.error || 'No se pudo eliminar');
    }
  })
  .catch(() => toastr.error('Error al eliminar archivo'));
}

// ...eliminado renombrar carpeta...

function previewFile(path, type) {
  const win = window.open('', '_blank');
  if (!win) return toastr.warning('Desbloquea los pop-ups');
  let content = '';
  if (type.startsWith('image/')) {
    content = `<img src="${path}" style="max-width:100%">`;
    win.document.write(content);
  } else if (type === 'application/pdf') {
    content = `<embed src="${path}" type="application/pdf" width="100%" height="600px">`;
    win.document.write(content);
  } else if (type.startsWith('text/')) {
    fetch(path).then(r => r.text()).then(txt => {
      win.document.write(`<pre style="white-space:pre-wrap;">${txt}</pre>`);
    });
  } else {
    toastr.info('Vista previa no disponible para este tipo de archivo');
    win.close();
  }
}

function showProperties(path) {
  fetch('file_properties.php?path=' + encodeURIComponent(path))
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert(`Nombre: ${data.name}\nTamaño: ${data.size} KB\nTipo: ${data.type}\nModificado: ${data.modified}`);
      } else {
        toastr.error('No se pudieron obtener propiedades');
      }
    });
}

function downloadMultipleFiles(paths) {
  if (!paths.length) return;
  
  paths.forEach(path => {
    const url = `download_file.php?path=${encodeURIComponent(path)}`;
    const a = document.createElement('a');
    a.href = url;
    a.download = ''; // Esto indica que es descarga
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  });
}


// Cuando se cambian los checkboxes, habilitar o no los botones
function updateButtonsState() {
  const checkedCount = document.querySelectorAll('.file-checkbox:checked').length;
  document.getElementById('delete-selected').disabled = checkedCount === 0;
  document.getElementById('download-selected').disabled = checkedCount === 0;
  document.getElementById('copy-selected').disabled = checkedCount === 0;
  document.getElementById('cut-selected').disabled = checkedCount === 0;
}

// Seleccionar todos
document.addEventListener('change', e => {
  if (e.target.id === 'select-all-files') {
    const checked = e.target.checked;
    document.querySelectorAll('.file-checkbox').forEach(chk => chk.checked = checked);
    updateButtonsState();
  } else if (e.target.classList.contains('file-checkbox')) {
    updateButtonsState();
  }
});

// Eliminar archivos seleccionados
document.getElementById('delete-selected').addEventListener('click', () => {
  const selectedPaths = Array.from(document.querySelectorAll('.file-checkbox:checked'))
    .map(chk => chk.dataset.path);

  if (selectedPaths.length === 0) return;

  // Opcional: Confirmar la eliminación
  if (!confirm(`¿Eliminar ${selectedPaths.length} archivo(s)? Esta acción no se puede deshacer.`)) return;

  fetch('delete_files.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({ paths: selectedPaths })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      toastr.success(`Se eliminaron ${selectedPaths.length} archivo(s)`);
      loadFolder(currentFolder);
    } else {
      toastr.error(data.error || 'Error al eliminar archivos');
    }
  })
  .catch(() => toastr.error('Error al eliminar archivos'));
});

// Descargar archivos seleccionados
document.getElementById('download-selected').addEventListener('click', () => {
  const selectedPaths = Array.from(document.querySelectorAll('.file-checkbox:checked'))
    .map(chk => chk.dataset.path);

  if (selectedPaths.length === 0) return;

  downloadMultipleFiles(selectedPaths);
});

let previewModal;

document.addEventListener('DOMContentLoaded', () => {
  // Ahora que el DOM está listo, inicializamos el modal bootstrap
  previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
});

document.addEventListener('dblclick', e => {
  if (e.target.classList.contains('file-preview-link')) {
    e.preventDefault();

    const path = e.target.dataset.path;
    const type = e.target.dataset.type;
    const previewContent = document.getElementById('previewContent');

    let contentHtml = '';

    if (type.startsWith('image/')) {
      contentHtml = `<img src="${path}" alt="Imagen" style="max-width: 100%;">`;
      previewContent.innerHTML = contentHtml;
      previewModal.show();
    } else if (type === 'application/pdf') {
      contentHtml = `<embed src="${path}" type="application/pdf" width="100%" height="600px">`;
      previewContent.innerHTML = contentHtml;
      previewModal.show();
    } else if (type.startsWith('audio/')) {
      contentHtml = `<audio controls style="width: 100%;">
                       <source src="${path}" type="${type}">
                       Tu navegador no soporta el elemento de audio.
                     </audio>`;
      previewContent.innerHTML = contentHtml;
      previewModal.show();
    } else if (type.startsWith('text/')) {
      previewContent.innerHTML = '<pre>Cargando texto...</pre>';
      previewModal.show();
      fetch(path).then(r => r.text()).then(txt => {
        previewContent.innerHTML = `<pre style="white-space: pre-wrap;">${txt}</pre>`;
      }).catch(() => {
        previewContent.innerHTML = '<p>Error cargando texto.</p>';
      });
    } else if (
      type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || // .docx
      type === 'application/msword' || // .doc
      type === 'application/vnd.ms-excel' || // .xls
      type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || // .xlsx
      type === 'application/vnd.ms-powerpoint' || // .ppt
      type === 'application/vnd.openxmlformats-officedocument.presentationml.presentation' // .pptx
    ) {
      // Usar Office Online Viewer (requiere URL pública)
      const encodedUrl = encodeURIComponent(window.location.origin + '/' + path);
      contentHtml = `
        <iframe src="https://view.officeapps.live.com/op/embed.aspx?src=${encodedUrl}" width="100%" height="600px" frameborder="0"></iframe>
      `;
      previewContent.innerHTML = contentHtml;
      previewModal.show();
    } else {
      contentHtml = `
        <p>Vista previa no disponible para este tipo de archivo.</p>
        <a href="${path}" download>Descargar archivo</a>
      `;
      previewContent.innerHTML = contentHtml;
      previewModal.show();
    }
  }
});

</script>

</body>
</html>
