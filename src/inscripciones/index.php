<?php

namespace App\inscripciones;

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

session_start();

$conn = Connection::get();
$inscripciones = $conn->query('
    SELECT 
        i.id, i.fecha, i.tipo_discapacidad,
        e.nombres, e.apellidos, e.ci, e.telefono,
        e.nombre_tutor, e.telefono_tutor
    FROM inscripciones i
    INNER JOIN estudiantes e ON i.estudiante_id = e.id
    WHERE i.deleted_at IS NULL
')->fetchAll(\PDO::FETCH_ASSOC);

$rowsHtml = '';

foreach ($inscripciones as $inscripcion) {
	$id = htmlspecialchars($inscripcion['id']);
	$nombreCompleto = htmlspecialchars($inscripcion['nombres'] . ' ' . $inscripcion['apellidos']);
	$ci = htmlspecialchars($inscripcion['ci']);
	$telefono = htmlspecialchars($inscripcion['telefono']);
	$nombreTutor = htmlspecialchars($inscripcion['nombre_tutor']);
	$telefonoTutor = htmlspecialchars($inscripcion['telefono_tutor']);
	$tipoDiscapacidad = htmlspecialchars($inscripcion['tipo_discapacidad']);

	$rowsHtml .= <<<HTML
    <tr>
      <td>{$nombreCompleto}</td>
      <td>{$ci}</td>
      <td>{$telefono}</td>
      <td>{$nombreTutor}</td>
      <td>{$telefonoTutor}</td>
      <td>{$tipoDiscapacidad}</td>
      <td class="d-flex gap-1">
        <a href="/src/inscripciones/edit.php?id={$id}" class="btn btn-warning btn-sm">
          <i class="bi bi-pencil"></i>
        </a>
        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalEliminar{$id}">
          <i class="bi bi-trash"></i>
        </button>
      </td>
    </tr>

    <!-- Modal -->
    <div class="modal fade" id="modalEliminar{$id}" tabindex="-1" aria-labelledby="modalEliminarLabel{$id}" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="POST" action="/src/inscripciones/delete.php">
            <div class="modal-header">
              <h5 class="modal-title" id="modalEliminarLabel{$id}">Confirmar eliminación</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
              ¿Estás seguro de que deseas eliminar esta inscripción?
              <input type="hidden" name="id" value="{$id}">
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-danger">Eliminar</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    HTML;
}

// Check for success message
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

echo <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Listado de Inscripciones</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container my-4">
	<div class="d-flex justify-content-between align-items-center mb-4">
  	  <h2>Listado de Inscripciones</h2>
  	    <a href="/src/inscripciones/create.php" class="btn btn-success">
    	  <i class="bi bi-plus-lg"></i> Nueva inscripción
  		</a>
	</div>
    {$toastHtml}
    <div class="table-responsive">
      <table class="table table-striped table-hover table-bordered table-sm">
        <thead class="table-dark">
          <tr>
            <th>Nombre completo</th>
            <th>Carnet de identidad</th>
            <th>Teléfono</th>
            <th>Nombre del tutor</th>
            <th>Teléfono del tutor</th>
            <th>Tipo de discapacidad</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {$rowsHtml}
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
HTML;
