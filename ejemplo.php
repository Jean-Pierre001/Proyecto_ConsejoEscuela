<?php
// Simulación de $files (usa tu código real)
$files = [
    ['filename' => 'foto1.jpg', 'filesize' => 204800, 'uploaded_at' => '2025-08-08 09:00:00', 'path' => 'uploads/foto1.jpg', 'type' => 'image/jpeg'],
    ['filename' => 'foto2.png', 'filesize' => 102400, 'uploaded_at' => '2025-08-07 10:15:00', 'path' => 'uploads/foto2.png', 'type' => 'image/png'],
    ['filename' => 'documento.pdf', 'filesize' => 500000, 'uploaded_at' => '2025-08-07 14:30:00', 'path' => 'uploads/documento.pdf', 'type' => 'application/pdf'],
    ['filename' => 'video.mp4', 'filesize' => 10485760, 'uploaded_at' => '2025-08-06 16:15:00', 'path' => 'uploads/video.mp4', 'type' => 'video/mp4'],
    ['filename' => 'musica.mp3', 'filesize' => 3072000, 'uploaded_at' => '2025-08-05 11:45:00', 'path' => 'uploads/musica.mp3', 'type' => 'audio/mpeg'],
    ['filename' => 'archivo.txt', 'filesize' => 1024, 'uploaded_at' => '2025-08-04 12:00:00', 'path' => 'uploads/archivo.txt', 'type' => 'text/plain'],
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Filtrador avanzado de Archivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; }
        .file-type-label { font-weight: 600; }
        .file-row { transition: all 0.3s ease; }
        .hidden { display: none !important; }
        .filter-group { margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="container">

    <h2 class="mb-4">Explorador de Archivos - Filtrado avanzado</h2>

    <!-- Filtros -->
    <div class="row mb-3">
        <div class="col-md-3 filter-group">
            <label for="filterType" class="form-label">Filtrar por tipo:</label>
            <select id="filterType" class="form-select">
                <option value="all" selected>Todos</option>
                <option value="image">Imágenes</option>
                <option value="video">Videos</option>
                <option value="audio">Audio</option>
                <option value="application">Documentos</option>
                <option value="text">Texto</option>
            </select>
        </div>
        <div class="col-md-3 filter-group">
            <label for="filterExtension" class="form-label">Filtrar por extensión:</label>
            <select id="filterExtension" class="form-select" disabled>
                <option value="all" selected>Todas</option>
            </select>
        </div>
        <div class="col-md-3 filter-group">
            <label class="form-label">Fecha subida (desde):</label>
            <input type="date" id="dateFrom" class="form-control" />
        </div>
        <div class="col-md-3 filter-group">
            <label class="form-label">Fecha subida (hasta):</label>
            <input type="date" id="dateTo" class="form-control" />
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 filter-group">
            <label class="form-label">Tamaño mínimo (KB):</label>
            <input type="number" id="sizeMin" class="form-control" min="0" placeholder="0" />
        </div>
        <div class="col-md-3 filter-group">
            <label class="form-label">Tamaño máximo (KB):</label>
            <input type="number" id="sizeMax" class="form-control" min="0" placeholder="∞" />
        </div>
    </div>

    <!-- Tabla de archivos -->
    <table class="table table-striped table-hover align-middle">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tamaño (KB)</th>
                <th>Fecha subida</th>
                <th>Tipo MIME</th>
            </tr>
        </thead>
        <tbody id="fileTableBody">
            <?php foreach($files as $file):
                // Obtener extensión en minúsculas
                $ext = strtolower(pathinfo($file['filename'], PATHINFO_EXTENSION));
            ?>
            <tr class="file-row" 
                data-type="<?= htmlspecialchars($file['type']) ?>" 
                data-ext="<?= $ext ?>"
                data-date="<?= htmlspecialchars($file['uploaded_at']) ?>"
                data-size="<?= $file['filesize'] ?>">
                <td><?= htmlspecialchars($file['filename']) ?></td>
                <td><?= number_format($file['filesize'] / 1024, 2) ?></td>
                <td><?= htmlspecialchars($file['uploaded_at']) ?></td>
                <td><span class="file-type-label"><?= htmlspecialchars($file['type']) ?></span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<script>
(() => {
    const filterType = document.getElementById('filterType');
    const filterExtension = document.getElementById('filterExtension');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    const sizeMin = document.getElementById('sizeMin');
    const sizeMax = document.getElementById('sizeMax');
    const rows = document.querySelectorAll('.file-row');

    // Map con extensiones agrupadas por tipo MIME (puedes ampliar)
    const extByType = {
        image: ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'],
        video: ['mp4', 'mov', 'avi', 'mkv', 'wmv', 'flv'],
        audio: ['mp3', 'wav', 'ogg', 'flac', 'aac'],
        application: ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar', '7z'],
        text: ['txt', 'csv', 'log', 'md'],
    };

    // Función para actualizar el dropdown de extensión según el filtro tipo
    function updateExtensionOptions() {
        const selectedType = filterType.value;
        filterExtension.innerHTML = ''; // limpiar opciones

        if (selectedType === 'all') {
            filterExtension.disabled = true;
            const opt = document.createElement('option');
            opt.value = 'all';
            opt.textContent = 'Todas';
            filterExtension.appendChild(opt);
            return;
        }

        const extensions = extByType[selectedType] || [];
        filterExtension.disabled = false;

        const allOpt = document.createElement('option');
        allOpt.value = 'all';
        allOpt.textContent = 'Todas';
        filterExtension.appendChild(allOpt);

        extensions.forEach(ext => {
            const opt = document.createElement('option');
            opt.value = ext;
            opt.textContent = ext.toUpperCase();
            filterExtension.appendChild(opt);
        });
    }

    // Función para filtrar filas
    function filterRows() {
        const selectedType = filterType.value;
        const selectedExt = filterExtension.value;
        const fromDate = dateFrom.value ? new Date(dateFrom.value) : null;
        const toDate = dateTo.value ? new Date(dateTo.value) : null;
        const minSize = sizeMin.value ? parseInt(sizeMin.value) * 1024 : null; // en bytes
        const maxSize = sizeMax.value ? parseInt(sizeMax.value) * 1024 : null; // en bytes

        rows.forEach(row => {
            const type = row.getAttribute('data-type'); // ej: "image/jpeg"
            const ext = row.getAttribute('data-ext'); // ej: "jpg"
            const date = new Date(row.getAttribute('data-date'));
            const size = parseInt(row.getAttribute('data-size'));

            // Filtro tipo MIME
            const typeMatch = (selectedType === 'all') || type.startsWith(selectedType);

            // Filtro extensión
            const extMatch = (selectedExt === 'all') || (ext === selectedExt);

            // Filtro fecha
            const fromMatch = !fromDate || date >= fromDate;
            const toMatch = !toDate || date <= toDate;

            // Filtro tamaño
            const minMatch = !minSize || size >= minSize;
            const maxMatch = !maxSize || size <= maxSize;

            if (typeMatch && extMatch && fromMatch && toMatch && minMatch && maxMatch) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    }

    // Eventos
    filterType.addEventListener('change', () => {
        updateExtensionOptions();
        filterRows();
    });

    filterExtension.addEventListener('change', filterRows);
    dateFrom.addEventListener('change', filterRows);
    dateTo.addEventListener('change', filterRows);
    sizeMin.addEventListener('input', filterRows);
    sizeMax.addEventListener('input', filterRows);

    // Inicializamos las opciones de extensión
    updateExtensionOptions();

})();
</script>

</body>
</html>
