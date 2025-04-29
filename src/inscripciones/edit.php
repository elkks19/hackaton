<?php

namespace App\inscripciones;

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

session_start();

$id = $_GET['id'] ?? null;
if (!$id) {
    http_response_code(400);
    exit('ID de inscripción no especificado.');
}

$conn = Connection::get();

// Obtener inscripción
$stmt = $conn->prepare('
    SELECT i.*, e.nombres, e.apellidos
    FROM inscripciones i
    INNER JOIN estudiantes e ON i.estudiante_id = e.id
    WHERE i.id = :id AND i.deleted_at IS NULL
');
$stmt->execute(['id' => $id]);
$inscripcion = $stmt->fetch(\PDO::FETCH_ASSOC);

if (!$inscripcion) {
    http_response_code(404);
    exit('Inscripción no encontrada.');
}

$fecha = htmlspecialchars($inscripcion['fecha']);
$tipoDiscapacidad = htmlspecialchars($inscripcion['tipo_discapacidad']);
$nombreEstudiante = htmlspecialchars($inscripcion['nombres'] . ' ' . $inscripcion['apellidos']);

// Obtener documentos existentes
$stmt = $conn->prepare('SELECT id, url_documento FROM documentos WHERE inscripcion_id = :id AND deleted_at IS NULL');
$stmt->execute(['id' => $id]);
$documentos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

echo <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Inscripción</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Editar inscripción</h2>
      <a href="/src/inscripciones/" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Volver al listado
      </a>
    </div>

    <form action="/src/inscripciones/update.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="{$id}">
      
      <div class="mb-3">
        <label class="form-label">Estudiante</label>
        <input type="text" class="form-control" value="{$nombreEstudiante}" disabled>
      </div>

      <div class="mb-3">
        <label class="form-label">Fecha</label>
        <input type="date" class="form-control" name="fecha" value="{$fecha}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Tipo de discapacidad</label>
        <input type="text" class="form-control" name="tipo_discapacidad" value="{$tipoDiscapacidad}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Documentos actuales</label>
        <div class="d-flex flex-wrap gap-3">
HTML;

foreach ($documentos as $doc) {
    $url = htmlspecialchars($doc['url_documento']);
    $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));

    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
        echo <<<HTML
          <div style="max-width:150px">
            <img src="{$url}" alt="documento" class="img-thumbnail mb-1">
            <div><a href="{$url}" target="_blank" class="btn btn-outline-secondary btn-sm w-100">Ver</a></div>
          </div>
HTML;
    } else {
        echo <<<HTML
          <div>
            <i class="bi bi-file-earmark-pdf" style="font-size:2rem;"></i><br>
            <a href="{$url}" target="_blank" class="btn btn-outline-secondary btn-sm mt-1">Abrir PDF</a>
          </div>
HTML;
    }
}

echo <<<HTML
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Agregar nuevos documentos (PDF o imagen)</label>
        <input type="file" class="form-control" name="documentos[]" accept=".pdf,image/*" multiple>
      </div>

      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Guardar cambios
      </button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
HTML;
