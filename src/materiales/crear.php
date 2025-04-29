<?php
require '../../conexion.php';

$tipos = $conexion->query("SELECT * FROM tipos_materiales");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Material</title>
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
            max-width: 800px;
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

        label {
            font-size: 1.1rem;
            color: var(--color-dark);
            display: block;
            margin-bottom: 0.5rem;
        }

        input, select, textarea {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1.5rem;
            border-radius: var(--radius);
            border: 2px solid var(--color-light);
            font-size: 1rem;
            background-color: var(--color-light);
            transition: var(--transition);
        }

        input:focus, select:focus, textarea:focus {
            border-color: var(--color-primary);
            outline: none;
        }

        .btn-submit, .btn-cancel {
            padding: 1rem 2rem;
            text-decoration: none;
            color: var(--color-white);
            background-color: var(--color-primary);
            border-radius: var(--radius);
            border: 2px solid var(--color-primary);
            font-size: 1rem;
            font-weight: 500;
            text-align: center;
            display: inline-block;
            transition: var(--transition);
        }

        .btn-submit:hover {
            background-color: var(--color-dark);
            border-color: var(--color-dark);
            transform: scale(1.05);
        }

        .btn-cancel {
            background-color: var(--color-secondary);
            margin-left: 1rem;
        }

        .btn-cancel:hover {
            background-color: var(--color-dark);
            border-color: var(--color-dark);
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
        <h1>Nuevo Material</h1>
        <p>Institución de Apoyo a Personas con Discapacidad Visual</p>
    </div>

    <div class="container">
        <div class="card">
            <h2 class="form-title">
                <i class="fas fa-plus-circle"></i> Crear Nuevo Material
            </h2>

            <form action="guardar.php" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" required>

                <label for="tipo_id">Tipo de Material:</label>
                <select name="tipo_id" required>
                    <?php while ($tipo = $tipos->fetch_assoc()) { ?>
                        <option value="<?= $tipo['id'] ?>"><?= $tipo['nombre'] ?></option>
                    <?php } ?>
                </select>

                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" rows="4" cols="40"></textarea>

                <div style="text-align: center;">
                    <input type="submit" value="Guardar" class="btn-submit">
                    <a href="index.php" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="footer">
        <p>&copy; <?= date('Y') ?> Sistema de Gestión de Materiales - Todos los derechos reservados</p>
    </div>
</body>
</html>
