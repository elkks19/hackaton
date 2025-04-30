<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$pdo = Connection::get();

// Obtener clases de hoy
$hoy = date('Y-m-d');
$stmt = $pdo->prepare("
    SELECT clases.id AS clase_id, cursos.nombre AS curso_nombre, clases.hora, usuarios.id AS profesor_id, usuarios.nombres, usuarios.apellidos
    FROM clases
    INNER JOIN cursos ON clases.curso_id = cursos.id
    INNER JOIN usuarios ON cursos.profesor_id = usuarios.id
");
$clases = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
$titulo = "Asistencia Profesores";
$pagina = "Asistencia Profesores";
?>

<?php ob_start(); ?>

    <style>
        body {
            background-color: #fff8f0;
            font-family: 'Segoe UI', sans-serif;
        }
        .titulo-principal {
            background: #f57c00;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn-guardar {
            background-color: #f57c00;
            color: white;
            border: none;
        }
        .btn-guardar:hover {
            background-color: #e65100;
        }
        .table th {
            background-color: #ff9800;
            color: white;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="titulo-principal">
        <h1>Asistencia de Profesores</h1>
        <p>Listado de clases para hoy</p>
    </div>

    <?php if (count($clases) > 0): ?>
        <?php foreach ($clases as $clase): ?>
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark fw-bold">
                    Curso: <?php echo htmlspecialchars($clase['curso_nombre']); ?> — Hora: <?php echo htmlspecialchars($clase['hora']); ?>
                </div>
                <div class="card-body">
                    <form method="post" action="guardar_asistencia_prof.php">
                        <input type="hidden" name="clase_id" value="<?php echo $clase['clase_id']; ?>">
                        <input type="hidden" name="profesor_id" value="<?php echo $clase['profesor_id']; ?>">

                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>Asistió</th>
                                    <th>Profesor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input class="form-check-input" type="checkbox" name="asistencia" value="1">
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($clase['nombres'] . ' ' . $clase['apellidos']); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="text-center">
                            <button type="submit" class="btn btn-guardar rounded-pill px-4 py-2">Guardar Asistencia</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info text-center fw-bold">
            No hay clases programadas para hoy.
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php
$contenido = ob_get_clean(); // Guarda el contenido generado
include '../layout/layout.php'; // Muestra el layout con el contenido insertado
?>
