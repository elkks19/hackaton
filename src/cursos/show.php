<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conn = Connection::get();

if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    die("ID de curso inválido.");
}

$id = $_GET['id'];

// Obtener los datos del curso
$stmt = $conn->prepare("SELECT c.nombre AS nombre_curso, c.descripcion, c.fecha_inicio, c.fecha_fin, c.deleted_at,
                               CONCAT(u.nombres, ' ', u.apellidos) AS profesor
                        FROM cursos c
                        LEFT JOIN usuarios u ON c.profesor_id = u.id
                        WHERE c.id = ?");
$stmt->execute([$id]);
$curso = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$curso) {
    die("Curso no encontrado.");
}

// Obtener los estudiantes asociados al curso
$stmt_estudiantes = $conn->prepare("SELECT CONCAT(e.nombres, ' ', e.apellidos) AS nombre_completo, e.ci
                                   FROM estudiantes e
                                   INNER JOIN estudiantes_curso ec ON e.id = ec.estudiante_id
                                   WHERE ec.curso_id = ?");
$stmt_estudiantes->execute([$id]);
$estudiantes = $stmt_estudiantes->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
$titulo = "Detalle del Curso";
$pagina = "Ver Curso";
?>

<?php ob_start(); ?>
    <style>
        .card {
            background-color: #fff;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 4px 8px rgba(204, 85, 0, 0.1);
            max-width: 800px;
            margin: 2rem auto;
        }

        .card h2 {
            margin-bottom: 1rem;
            color: #FF7F00;
        }

        .card p {
            font-size: 1rem;
            margin: 0.5rem 0;
            color: #333;
        }

        .label {
            font-weight: bold;
            color: #CC5500;
        }

        .back-button {
            display: inline-block;
            margin-top: 1.5rem;
            padding: 0.6rem 1.2rem;
            background-color: #FF7F00;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background-color: #CC5500;
        }

        .badge {
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .badge-active {
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }

        .badge-inactive {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        .students-list {
            margin-top: 2rem;
        }

        .students-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .students-list th, .students-list td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .students-list th {
            background-color: #FF7F00;
            color: white;
        }

        .students-list tr:hover {
            background-color: rgba(255, 224, 189, 0.3);
        }
    </style>

    <div class="card">
        <h2><?= htmlspecialchars($curso['nombre_curso']) ?></h2>
        <p><span class="label">Descripción:</span> <?= nl2br(htmlspecialchars($curso['descripcion'])) ?></p>
        <p><span class="label">Fecha de Inicio:</span> <?= htmlspecialchars($curso['fecha_inicio']) ?></p>
        <p><span class="label">Fecha de Fin:</span> <?= htmlspecialchars($curso['fecha_fin']) ?></p>
        <p><span class="label">Profesor:</span> <?= htmlspecialchars($curso['profesor']) ?></p>
        <p><span class="label">Estado:</span>
            <?php if (is_null($curso['deleted_at'])): ?>
                <span class="badge badge-active">Activo</span>
            <?php else: ?>
                <span class="badge badge-inactive">Inactivo</span>
            <?php endif; ?>
        </p>

        <h3>Estudiantes Inscritos</h3>
        <div class="students-list">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cédula</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estudiantes as $estudiante): ?>
                    <tr>
                        <td><?= htmlspecialchars($estudiante['nombre_completo']) ?></td>
                        <td><?= htmlspecialchars($estudiante['ci']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <a href="index.php" class="back-button">← Volver a la lista</a>
    </div>

<?php
$contenido = ob_get_clean();
include '../layout/layout.php';
?>
