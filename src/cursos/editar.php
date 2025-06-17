<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conn = Connection::get();

// Verificar que se ha pasado un ID válido de curso
if (!isset($_GET['id'])) {
    die("ID de curso no proporcionado");
}

$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
if ($id === false || $id <= 0) {
    die("ID de curso inválido");
}

// Traemos los datos del curso
$stmt = $conn->prepare("SELECT * FROM cursos WHERE id = ?");
$stmt->execute([$id]);
$curso = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$curso) {
    die("Curso no encontrado");
}

// Traemos todos los profesores
$sql = "SELECT id, CONCAT(nombres, ' ', apellidos) AS nombre_completo FROM usuarios";
$stmt = $conn->query($sql);
$profesores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traemos todos los estudiantes
$sql_estudiantes = "SELECT id, CONCAT(nombres, ' ', apellidos) AS nombre_completo FROM estudiantes";
$stmt = $conn->query($sql_estudiantes);
$estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traemos los estudiantes que ya están asignados al curso
$sql_estudiantes_curso = "SELECT estudiante_id FROM estudiantes_curso WHERE curso_id = ?";
$stmt = $conn->prepare($sql_estudiantes_curso);
$stmt->execute([$id]);
$estudiantes_asignados = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Curso - Institución Inclusiva</title>
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
            max-width: 700px;
            margin: 2rem auto;
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

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--color-light);
            border-radius: var(--radius);
            font-size: 1rem;
            transition: var(--transition);
            background-color: var(--color-white);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(255, 127, 0, 0.25);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
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

        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            text-decoration: none;
            color: var(--color-text-light);
            font-weight: 500;
            transition: var(--transition);
        }

        .back-link:hover {
            color: var(--color-primary);
        }

        .back-link i {
            margin-right: 0.5rem;
        }

        .form-help {
            font-size: 0.85rem;
            color: var(--color-text-light);
            margin-top: 0.25rem;
        }

        .footer {
            text-align: center;
            margin-top: 2rem;
            padding: 1.5rem;
            color: var(--color-text-light);
            font-size: 0.9rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
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
            <h2 class="form-title">
                <i class="fas fa-edit"></i> Editar Curso
            </h2>

            <form action="actualizar.php" method="POST">
                <input type="hidden" name="id" value="<?= $curso['id'] ?>">

                <div class="form-group">
                    <label for="nombre">Nombre del Curso:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" value="<?= htmlspecialchars($curso['nombre']) ?>" required>
                    <div class="form-help">Ingrese un nombre descriptivo y fácil de entender.</div>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" class="form-control" required><?= htmlspecialchars($curso['descripcion']) ?></textarea>
                    <div class="form-help">Describa brevemente el contenido y objetivos del curso.</div>
                </div>

                <div class="form-group">
                    <label for="fecha_inicio">Fecha de Inicio:</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="<?= $curso['fecha_inicio'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="fecha_fin">Fecha de Finalización:</label>
                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" value="<?= $curso['fecha_fin'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="profesor_id">Profesor Asignado:</label>
                    <select id="profesor_id" name="profesor_id" class="form-control" required>
                        <option value="">Seleccione un profesor</option>
                        <?php foreach ($profesores as $profesor): ?>
                            <option value="<?= $profesor['id'] ?>" <?= $profesor['id'] == $curso['profesor_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($profesor['nombre_completo']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Estudiantes -->
                <div class="form-group">
                    <label for="estudiantes">Estudiantes Asignados:</label>
                    <?php foreach ($estudiantes as $estudiante): ?>
                        <div>
                            <input type="checkbox" name="estudiantes[]" value="<?= $estudiante['id'] ?>" 
                            <?= in_array($estudiante['id'], $estudiantes_asignados) ? 'checked' : '' ?>>
                            <?= htmlspecialchars($estudiante['nombre_completo']) ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>

            <a href="index.php" class="back-link">
                <i class="fas fa-arrow-left"></i> Volver al Listado
            </a>
        </div>
    </div>

    <div class="footer">
        <p>&copy; <?= date('Y') ?> Sistema de Gestión de Cursos - Todos los derechos reservados</p>
    </div>
</body>
</html>
