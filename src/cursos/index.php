<?php
include 'conexion.php';

// Validación para restaurar curso
if (isset($_GET['restaurar'])) {
    $id = filter_var($_GET['restaurar'], FILTER_VALIDATE_INT);
    if ($id === false || $id <= 0) {
        die("ID de curso inválido");
    }
    
    // Verificar que el curso existe antes de restaurar
    $check = $conn->prepare("SELECT id FROM cursos WHERE id = ?");
    $check->execute([$id]);
    if ($check->rowCount() === 0) {
        die("El curso no existe");
    }
    
    $stmt = $conn->prepare("UPDATE cursos SET deleted_at = NULL WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit();
}

// Validación para eliminar curso
if (isset($_GET['eliminar'])) {
    $id = filter_var($_GET['eliminar'], FILTER_VALIDATE_INT);
    if ($id === false || $id <= 0) {
        die("ID de curso inválido");
    }
    
    // Verificar que el curso existe y no está ya eliminado
    $check = $conn->prepare("SELECT id FROM cursos WHERE id = ? AND deleted_at IS NULL");
    $check->execute([$id]);
    if ($check->rowCount() === 0) {
        die("El curso no existe o ya está inactivo");
    }
    
    $stmt = $conn->prepare("UPDATE cursos SET deleted_at = NOW() WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit();
}

// Mostrar todos los cursos con el nombre del profesor
$sql = "SELECT c.id, c.nombre AS nombre_curso, c.descripcion, c.fecha_inicio, c.fecha_fin, 
               c.deleted_at, CONCAT(u.nombres, ' ', u.apellidos) AS profesor
        FROM cursos c
        LEFT JOIN usuarios u ON c.profesor_id = u.id";
$stmt = $conn->query($sql);
$cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Cursos - Institución Inclusiva</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --color-primary: #FF7F00;
            --color-secondary: #FF9E3D;
            --color-accent: #FFB266;
            --color-light: #FFE0BD;
            --color-dark: #CC5500;
            --color-text: #333333;
            --color-text-light: #666666;
            --color-background: #FFF9F2;
            --color-white: #FFFFFF;
            --shadow: 0 4px 8px rgba(204, 85, 0, 0.1);
            --radius: 10px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'Arial', sans-serif;
            background-color: var(--color-background);
            color: var(--color-text);
            line-height: 1.6;
        }

        .header {
            background: linear-gradient(135deg, var(--color-primary), var(--color-dark));
            color: var(--color-white);
            padding: 1.5rem;
            text-align: center;
            border-bottom: 4px solid var(--color-accent);
        }

        .header h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .header p {
            font-size: 1rem;
            opacity: 0.9;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .card {
            background-color: var(--color-white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .button {
            display: inline-flex;
            align-items: center;
            background-color: var(--color-primary);
            color: var(--color-white);
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .button:hover {
            background-color: var(--color-dark);
            transform: translateY(-2px);
        }

        .button i {
            margin-right: 0.5rem;
        }

        .table-container {
            overflow-x: auto;
            margin-top: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: var(--radius);
            overflow: hidden;
        }

        th {
            background-color: var(--color-primary);
            color: var(--color-white);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid var(--color-light);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: rgba(255, 224, 189, 0.3);
        }

        .badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-align: center;
        }

        .badge-active {
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }

        .badge-inactive {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: var(--radius);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
        }

        .btn i {
            margin-right: 0.35rem;
        }

        .btn-edit {
            background-color: var(--color-secondary);
            color: var(--color-white);
        }

        .btn-edit:hover {
            background-color: var(--color-primary);
        }

        .btn-delete {
            background-color: #dc3545;
            color: var(--color-white);
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .btn-restore {
            background-color: #17a2b8;
            color: var(--color-white);
        }

        .btn-restore:hover {
            background-color: #138496;
        }

        .footer {
            text-align: center;
            margin-top: 2rem;
            padding: 1.5rem;
            background-color: var(--color-primary);
            color: var(--color-white);
            border-radius: var(--radius) var(--radius) 0 0;
        }

        .footer p {
            font-size: 0.9rem;
        }

        .course-name {
            font-weight: 600;
            color: var(--color-primary);
        }

        .date {
            white-space: nowrap;
        }

        .description {
            max-width: 250px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Media Queries */
        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
            }
            
            .table-responsive th:nth-child(2),
            .table-responsive td:nth-child(2) {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .table-responsive th:nth-child(3),
            .table-responsive td:nth-child(3),
            .table-responsive th:nth-child(4),
            .table-responsive td:nth-child(4) {
                display: none;
            }
            
            .actions {
                flex-direction: column;
                align-items: stretch;
            }
            
            .button {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sistema de Gestión de Cursos</h1>
        <p>Institución de Apoyo a Personas con Discapacidad Visual</p>
    </div>

    <div class="container">
        <div class="card">
            <div class="actions">
                <a href="crear.php" class="button">
                    <i class="fas fa-plus-circle"></i> Crear Nuevo Curso
                </a>
            </div>

            <div class="table-container">
                <table class="table-responsive">
                    <thead>
                        <tr>
                            <th>Nombre del Curso</th>
                            <th>Descripción</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Profesor</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cursos as $curso): ?>
                        <tr>
                            <td class="course-name"><?= htmlspecialchars($curso['nombre_curso']) ?></td>
                            <td class="description"><?= htmlspecialchars($curso['descripcion']) ?></td>
                            <td class="date"><?= htmlspecialchars($curso['fecha_inicio']) ?></td>
                            <td class="date"><?= htmlspecialchars($curso['fecha_fin']) ?></td>
                            <td><?= htmlspecialchars($curso['profesor']) ?></td>
                            <td>
                                <?php if (is_null($curso['deleted_at'])): ?>
                                    <span class="badge badge-active">Activo</span>
                                <?php else: ?>
                                    <span class="badge badge-inactive">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td class="action-buttons">
                                <a href="editar.php?id=<?= $curso['id'] ?>" class="btn btn-edit">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <?php if (is_null($curso['deleted_at'])): ?>
                                    <a href="?eliminar=<?= $curso['id'] ?>" class="btn btn-delete" onclick="return confirm('¿Está seguro que desea inactivar este curso?')">
                                        <i class="fas fa-ban"></i> Inactivar
                                    </a>
                                <?php else: ?>
                                    <a href="?restaurar=<?= $curso['id'] ?>" class="btn btn-restore" onclick="return confirm('¿Está seguro que desea activar este curso?')">
                                        <i class="fas fa-check-circle"></i> Activar
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; <?= date('Y') ?> Sistema de Gestión de Cursos - Todos los derechos reservados</p>
    </div>
</body>
</html>