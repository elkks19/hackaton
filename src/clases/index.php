<?php
include 'conexion.php';
$stmt = $conn->prepare("SELECT c.id, c.fecha, c.hora, c.estado, cu.nombre AS curso
                        FROM clases c
                        JOIN cursos cu ON c.curso_id = cu.id
                        WHERE c.deleted_at IS NULL
                        ORDER BY c.fecha DESC");
$stmt->execute();
$clases = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Clases - Institución Inclusiva</title>
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

        .badge-realizada {
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }

        .badge-pospuesta {
            background-color: rgba(255, 193, 7, 0.15);
            color: #ffc107;
        }

        .badge-cancelada {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        .badge-suspendida {
            background-color: rgba(108, 117, 125, 0.15);
            color: #6c757d;
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

        .course-name {
            font-weight: 600;
            color: var(--color-primary);
        }

        .date {
            white-space: nowrap;
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

        /* Media Queries */
        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
            }
        }

        @media (max-width: 576px) {
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
        <h1>Clases</h1>
        <p>Institución de Apoyo a Personas con Discapacidad Visual</p>
    </div>

    <div class="container">
        <div class="card">
            <div class="actions">
                <a href="crear.php" class="button">
                    <i class="fas fa-plus-circle"></i> Nueva Clase
                </a>
            </div>

            <div class="table-container">
                <table class="table-responsive">
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($clases as $row): ?>
                        <tr>
                            <td class="course-name"><?= htmlspecialchars($row['curso']) ?></td>
                            <td class="date"><?= htmlspecialchars($row['fecha']) ?></td>
                            <td class="date"><?= htmlspecialchars($row['hora']) ?></td>
                            <td>
                                <?php 
                                    $badgeClass = '';
                                    switch($row['estado']) {
                                        case 'REALIZADA': $badgeClass = 'badge-realizada'; break;
                                        case 'POSPUESTA': $badgeClass = 'badge-pospuesta'; break;
                                        case 'CANCELADA': $badgeClass = 'badge-cancelada'; break;
                                        case 'SUSPENDIDA': $badgeClass = 'badge-suspendida'; break;
                                    }
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($row['estado']) ?></span>
                            </td>
                            <td class="action-buttons">
                                <a href="editar.php?id=<?= $row['id'] ?>" class="btn btn-edit">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
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