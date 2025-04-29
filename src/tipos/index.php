<?php
require '../../conexion.php';

$resultado = $conexion->query("SELECT * FROM tipos_materiales");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipos de Materiales</title>
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
        <h1>Tipos de Materiales</h1>
        <p>Gestión de Tipos de Materiales para el sistema</p>
    </div>

    <div class="container">
        <a href="crear.php" class="btn-nuevo"><i class="fas fa-plus-circle"></i> Nuevo Tipo</a>

        <div class="card">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
                <?php while ($fila = $resultado->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $fila['id'] ?></td>
                        <td><?= $fila['nombre'] ?></td>
                        <td>
                            <a href="editar.php?id=<?= $fila['id'] ?>">Editar</a>
                            <a href="eliminar.php?id=<?= $fila['id'] ?>" onclick="return confirm('¿Seguro?')">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <div class="footer">
        <p>&copy; <?= date('Y') ?> Sistema de Gestión de Tipos de Materiales - Todos los derechos reservados</p>
    </div>
</body>
</html>
