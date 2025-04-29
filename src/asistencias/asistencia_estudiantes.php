<?php
include 'conexion.php'; // Ajusta la ruta según tu estructura

// Obtener clases de hoy
$hoy = date('Y-m-d');
$stmt = $pdo->prepare("
    SELECT clases.id AS clase_id, cursos.nombre AS curso_nombre, clases.hora 
    FROM clases
    INNER JOIN cursos ON clases.curso_id = cursos.id
    WHERE clases.fecha = :hoy AND clases.deleted_at
");
$stmt->execute(['hoy' => $hoy]);
$clases = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
$titulo = "Asistencia Estudiantes";
$pagina = "Asistencia Estudiantes";
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

<div class="container mt-5">
    <div class="titulo-principal">
        <h1>Asistencia de Estudiantes</h1>
        <p>Solo para clases del día de hoy</p>
    </div>

    <?php if (count($clases) > 0): ?>
        <?php foreach ($clases as $clase): ?>
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark fw-bold">
                    Curso: <?php echo htmlspecialchars($clase['curso_nombre']); ?> — Hora: <?php echo htmlspecialchars($clase['hora']); ?>
                </div>
                <div class="card-body">
                    <form method="post" action="guardar_asistencia_est.php">
                        <input type="hidden" name="clase_id" value="<?php echo $clase['clase_id']; ?>">

                        <table class="table table-bordered table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Asistió</th>
                                    <th>Nombre Completo</th>
                                    <th>CI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt2 = $pdo->prepare("
                                    SELECT e.id, e.nombres, e.apellidos, e.ci
                                    FROM estudiantes_curso ec
                                    INNER JOIN estudiantes e ON ec.estudiante_id = e.id
                                    WHERE ec.curso_id = :curso_id AND e.deleted_at IS NULL
                                ");
                                $stmt2->execute(['curso_id' => $clase['clase_id']]);
                                $estudiantes = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($estudiantes as $estudiante):
                                ?>
                                <tr>
                                    <td>
                                        <input class="form-check-input" type="checkbox" name="asistencia[]" value="<?php echo $estudiante['id']; ?>">
                                    </td>
                                    <td><?php echo htmlspecialchars($estudiante['nombres'] . ' ' . $estudiante['apellidos']); ?></td>
                                    <td><?php echo htmlspecialchars($estudiante['ci']); ?></td>
                                </tr>
                                <?php endforeach; ?>
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
