<?php
require '../../conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Tipo de Material</title>
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
            max-width: 600px;
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

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--color-text);
        }

        input[type="text"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--color-light);
            border-radius: var(--radius);
            font-size: 1rem;
            transition: var(--transition);
            background-color: var(--color-white);
        }

        input[type="text"]:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(255, 127, 0, 0.25);
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            justify-content: space-between;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            font-size: 1rem;
            flex: 1;
        }

        .btn i {
            margin-right: 0.5rem;
        }

        .btn-primary {
            background-color: var(--color-primary);
            color: var(--color-white);
        }

        .btn-primary:hover {
            background-color: var(--color-dark);
        }

        .btn-secondary {
            background-color: var(--color-light);
            color: var(--color-dark);
            border: 1px solid var(--color-accent);
        }

        .btn-secondary:hover {
            background-color: var(--color-accent);
            color: var(--color-white);
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
        <h1>Nuevo Tipo de Material</h1>
        <p>Formulario para agregar un nuevo tipo de material</p>
    </div>

    <div class="container">
        <div class="card">
            <h2 class="form-title"><i class="fas fa-plus-circle"></i> Crear Nuevo Tipo</h2>

            <form action="guardar.php" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="footer">
        <p>&copy; <?= date('Y') ?> Sistema de Gestión de Tipos de Materiales - Todos los derechos reservados</p>
    </div>
</body>
</html>
