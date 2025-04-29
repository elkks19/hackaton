<?php

namespace App\inscripciones;

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

session_start();

$conn = Connection::get();

// Obtener estudiantes para el select
$estudiantes = $conn->query('
    SELECT id, CONCAT(nombres, " ", apellidos, " (", ci, ")") as nombre_completo
    FROM estudiantes
    WHERE deleted_at IS NULL
')->fetchAll(\PDO::FETCH_ASSOC);

// Mostrar mensaje si viene desde store.php
$toastHtml = '';
if (!empty($_SESSION['success'])) {
    $toastHtml = <<<HTML
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div class="toast align-items-center text-white bg-success border-0 show" role="alert">
    <div class="d-flex">
      <div class="toast-body">
        {$_SESSION['success']}
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
    </div>
  </div>
</div>
HTML;
    unset($_SESSION['success']);
}

$hoy = date('Y-m-d');

echo <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear Inscripción</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Crear nueva inscripción</h2>
      <a href="/src/inscripciones/" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Volver al listado
      </a>
    </div>

    {$toastHtml}

    <form action="/src/inscripciones/store.php" method="POST" enctype="multipart/form-data" class="mt-4">
      <div class="mb-3">
        <label for="estudiante_id" class="form-label">Estudiante</label>
        <select class="form-select" name="estudiante_id" required>
HTML;

foreach ($estudiantes as $e) {
    $id = htmlspecialchars($e['id']);
    $nombre = htmlspecialchars($e['nombre_completo']);
    echo "<option value=\"{$id}\">{$nombre}</option>";
}

echo <<<HTML
        </select>
      </div>

      <div class="mb-3">
        <label for="fecha" class="form-label">Fecha</label>
        <input type="date" class="form-control" name="fecha" value="{$hoy}" required>
      </div>

      <div class="mb-3">
        <label for="tipo_discapacidad" class="form-label">Tipo de discapacidad</label>
        <input type="text" class="form-control" name="tipo_discapacidad" required>
      </div>

	  <div class="mb-3">
  		<label for="documento" class="form-label">Documentos (PDF o imagen)</label>
  		<input type="file" class="form-control" name="documentos[]" accept=".pdf,image/*" multiple required>
	  </div>

      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Guardar inscripción
      </button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
HTML;
