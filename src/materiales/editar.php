<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conexion = Connection::get();

$id = $_GET['id'];
$resultado = $conexion->query("SELECT * FROM materiales WHERE id = $id");
$material = $resultado->fetch();

$tipos = $conexion->query("SELECT * FROM tipos_materiales");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Material</title>
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

        .container {
            max-width: 700px;
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

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        select {
            padding: 0.7rem;
            border-radius: var(--radius);
            border: 1px solid var(--color-light);
            font-size: 1rem;
            background-color: var(--color-background);
        }

        .btn-submit {
            background-color: var(--color-primary);
            color: var(--color-white);
            padding: 0.8rem 2rem;
            border: none;
            border-radius: var(--radius);
            font-size: 1.1rem;
            cursor: pointer;
            transition: var(--transition);
            margin-right: 1rem;
        }

        .btn-submit:hover {
            background-color: var(--color-dark);
            transform: scale(1.05);
        }

        .btn-cancel {
            background-color: var(--color-secondary);
            color: var(--color-white);
            padding: 0.8rem 2rem;
            border-radius: var(--radius);
            font-size: 1.1rem;
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-cancel:hover {
            background-color: var(--color-dark);
            transform: scale(1.05);
        }

        #nuevo-tipo-container {
            display: none;
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
        <h1>Editar Material</h1>
        <p>Institución de Apoyo a Personas con Discapacidad Visual</p>
    </div>

    <div class="container">
        <div class="card">
            <h2 class="form-title"><i class="fas fa-edit"></i> Modificar Material</h2>

            <form action="actualizar.php" method="POST">
                <input type="hidden" name="id" value="<?= $material['id'] ?>">

                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($material['nombre']) ?>" required>

                <label for="tipo_id">Tipo de Material:</label>
                <select name="tipo_id" id="tipo_id" required onchange="mostrarNuevoTipo(this)">
                    <?php foreach($tipos->fetchAll() as $tipo) { ?>
                        <option value="<?= $tipo['id'] ?>" <?= $tipo['id'] == $material['tipo_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($tipo['nombre']) ?>
                        </option>
                    <?php } ?>
                    <option value="nuevo">Otro / Nuevo tipo…</option>
                </select>

                <div id="nuevo-tipo-container">
                    <label for="nuevo_tipo">Nuevo tipo de material:</label>
                    <input type="text" name="nuevo_tipo" id="nuevo_tipo">
                </div>

                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" rows="4" cols="40"><?= htmlspecialchars($material['descripcion']) ?></textarea>

                <div style="text-align: center;">
                    <input type="submit" value="Actualizar" class="btn-submit">
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

    <script>
        function mostrarNuevoTipo(select) {
            const container = document.getElementById('nuevo-tipo-container');
            if (select.value === 'nuevo') {
                container.style.display = 'block';
                document.getElementById('nuevo_tipo').setAttribute('required', 'required');
            } else {
                container.style.display = 'none';
                document.getElementById('nuevo_tipo').removeAttribute('required');
            }
        }

        window.onload = function () {
            const select = document.getElementById('tipo_id');
            if (select.value === 'nuevo') {
                mostrarNuevoTipo(select);
            }
        };
    </script>
</body>
</html>
