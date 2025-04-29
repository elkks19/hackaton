<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conexion = Connection::get();

$resultado = $conexion->query("
    SELECT m.id, m.nombre, m.descripcion, t.nombre AS tipo
    FROM materiales m
    JOIN tipos_materiales t ON m.tipo_id = t.id
    WHERE m.deleted_at IS NULL
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materiales - Institución Inclusiva</title>
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
            max-width: 1000px;
            margin: 3rem auto;
            padding: 0 1rem;
        }

        .card {
            background-color: var(--color-white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 2rem;
        }

        .form-title {
            margin-bottom: 1.5rem;
            color: var(--color-primary);
            text-align: center;
            font-size: 1.8rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
        }

        th, td {
            padding: 1rem;
            text-align: center;
            border: 2px solid var(--color-light);
        }

        th {
            background-color: var(--color-primary);
            color: var(--color-white);
        }

        tr:nth-child(even) {
            background-color: var(--color-light);
        }

        tr:hover {
            background-color: var(--color-accent);
            color: var(--color-dark);
        }

        a {
            padding: 0.5rem 1rem;
            margin: 0 0.5rem;
            background-color: var(--color-primary);
            color: var(--color-white);
            text-decoration: none;
            border-radius: var(--radius);
            font-weight: 500;
            transition: var(--transition);
        }

        a:hover {
            background-color: var(--color-dark);
            transform: scale(1.05);
        }

        .btn-nuevo {
            display: inline-block;
            background-color: var(--color-secondary);
            padding: 1rem 2rem;
            margin-bottom: 1rem;
            text-decoration: none;
            color: var(--color-white);
            border-radius: var(--radius);
            font-size: 1.2rem;
            transition: var(--transition);
        }

        .btn-nuevo:hover {
            background-color: var(--color-dark);
            transform: scale(1.05);
        }

        .action-buttons {
            display: flex;
            gap: 1rem; /* Espacio entre los botones */
            justify-content: center; /* Centrar los botones horizontalmente */
        }

        .footer {
            text-align: center;
            margin-top: 3rem;
            padding: 1.5rem;
            color: var(--color-text-light);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Materiales</h1>
        <p>Institución de Apoyo a Personas con Discapacidad Visual</p>
    </div>

    <div class="container">
        <a href="crear.php" class="btn-nuevo"><i class="fas fa-plus-circle"></i> Nuevo Material</a>

        <div class="card">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo de Material</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
                <?php while ($fila = $resultado->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $fila['id'] ?></td>
                        <td><?= $fila['nombre'] ?></td>
                        <td><?= $fila['tipo'] ?></td>
                        <td><?= $fila['descripcion'] ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="editar.php?id=<?= $fila['id'] ?>">Editar</a>
                                <a href="eliminar.php?id=<?= $fila['id'] ?>" onclick="return confirm('¿Seguro?')">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <div class="footer">
        <p>&copy; <?= date('Y') ?> Sistema de Gestión de Materiales - Todos los derechos reservados</p>
    </div>
</body>
</html>
