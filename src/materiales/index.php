<?php

require_once __DIR__ . '/../index.php';

$titulo = "Materiales";
$pagina = "Materiales";
ob_start();

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
    <link rel="stylesheet" href="/public/font-awesome.css">
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

        .materiales-page {
            font-family: 'Segoe UI', 'Arial', sans-serif;
            background-color: var(--color-background);
            color: var(--color-text);
            line-height: 1.6;
        }

        .materiales-page .header {
            background: linear-gradient(135deg, var(--color-primary), var(--color-dark));
            color: var(--color-white);
            padding: 1.5rem;
            text-align: center;
            border-bottom: 4px solid var(--color-accent);
        }

        .materiales-page .header h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .materiales-page .header p {
            font-size: 1rem;
            opacity: 0.9;
        }

        .materiales-page .container {
            max-width: 1000px;
            margin: 3rem auto;
            padding: 0 1rem;
        }

        .materiales-page .card {
            background-color: var(--color-white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 2rem;
        }

        .materiales-page .form-title {
            margin-bottom: 1.5rem;
            color: var(--color-primary);
            text-align: center;
            font-size: 1.8rem;
        }

        .materiales-page table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
        }

        .materiales-page th, 
        .materiales-page td {
            padding: 1rem;
            text-align: center;
            border: 2px solid var(--color-light);
        }

        .materiales-page th {
            background-color: var(--color-primary);
            color: var(--color-white);
        }

        .materiales-page tr:nth-child(even) {
            background-color: var(--color-light);
        }

        .materiales-page tr:hover {
            background-color: var(--color-accent);
            color: var(--color-dark);
        }

        .materiales-page a {
            padding: 0.5rem 1rem;
            margin: 0 0.5rem;
            background-color: var(--color-primary);
            color: var(--color-white);
            text-decoration: none;
            border-radius: var(--radius);
            font-weight: 500;
            transition: var(--transition);
        }

        .materiales-page a:hover {
            background-color: var(--color-dark);
            transform: scale(1.05);
        }

        .materiales-page .btn-nuevo {
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

        .materiales-page .btn-nuevo:hover {
            background-color: var(--color-dark);
            transform: scale(1.05);
        }

        .materiales-page .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .materiales-page .footer {
            text-align: center;
            margin-top: 3rem;
            padding: 1.5rem;
            color: var(--color-text-light);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="materiales-page">
        <div class="header">
            <h1>Materiales</h1>
            <p>Institución de Apoyo a Personas con Discapacidad Visual</p>
        </div>

        <div class="container">
			<div class="flex">
            	<a href="crear.php" class="btn-nuevo"><i class="fas fa-plus-circle"></i> Nuevo Material</a>
            	<a href="audiolibros.php" class="btn-nuevo"> Convertir pdf a audiolibro </a>
			</div>

            <div class="card">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo de Material</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                    <?php foreach ($resultado->fetchAll() as $fila) { ?>
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
    </div>
</body>
</html>

<?php
	$contenido = ob_get_clean(); // Guarda el contenido generado
	include '../layout/layout.php'; // Muestra el layout con el contenido insertado
?>
