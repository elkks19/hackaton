<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conn = Connection::get();

// Obtener cursos activos
$stmt = $conn->query("SELECT id, nombre FROM cursos");
$cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Clase - Institución Inclusiva</title>
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

        .required-field::after {
            content: "*";
            color: #dc3545;
            margin-left: 4px;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: var(--radius);
            background-color: rgba(255, 127, 0, 0.1);
            border-left: 4px solid var(--color-primary);
        }

        .alert-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--color-primary);
        }

        .footer {
            text-align: center;
            margin-top: 2rem;
            padding: 1.5rem;
            color: var(--color-text-light);
            font-size: 0.9rem;
        }

        .is-invalid {
            border-color: #dc3545;
        }
        
        .invalid-feedback {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 0.25rem;
            display: none;
        }
        
        .is-invalid + .invalid-feedback {
            display: block;
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
    

    <div class="container">
        <div class="card">
            <h2 class="form-title">
                <i class="fas fa-plus-circle"></i> Nueva Clase
            </h2>

            <div class="alert">
                <div class="alert-title">Información Importante</div>
                <p>Todos los campos marcados con (*) son obligatorios. Complete el formulario con los datos de la nueva clase.</p>
            </div>

            <?php if (empty($cursos)): ?>
                <div class="alert alert-warning">
                    No hay cursos disponibles. Por favor crea uno primero.
                </div>
            <?php else: ?>
                <form action="guardar.php" method="POST" onsubmit="return validarFormulario()">
                    <div class="form-group">
                        <label for="curso_id" class="required-field">Curso:</label>
                        <select id="curso_id" name="curso_id" class="form-control" required>
                            <?php foreach($cursos as $c): ?>
                                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fecha" class="required-field">Fecha:</label>
                        <input type="date" id="fecha" name="fecha" class="form-control" required>
                        <div class="invalid-feedback">La fecha no puede ser anterior al día de hoy</div>
                    </div>

                    <div class="form-group">
                        <label for="hora" class="required-field">Hora:</label>
                        <input type="time" id="hora" name="hora" class="form-control" required>
                        <div class="invalid-feedback">Por favor ingresa una hora válida</div>
                    </div>

                    <div class="form-group">
                        <label for="estado" class="required-field">Estado:</label>
                        <select id="estado" name="estado" class="form-control" required>
                            <option value="REALIZADA">REALIZADA</option>
                            <option value="POSPUESTA">POSPUESTA</option>
                            <option value="CANCELADA">CANCELADA</option>
                            <option value="SUSPENDIDA">SUSPENDIDA</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar Clase
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>

                <a href="index.php" class="back-link">
                    <i class="fas fa-arrow-left"></i> Volver al Listado
                </a>

                <script>
                function validarFormulario() {
                    let valido = true;
                    
                    // Validar fecha
                    const fechaInput = document.getElementById('fecha');
                    const fechaSeleccionada = new Date(fechaInput.value);
                    const hoy = new Date();
                    hoy.setHours(0, 0, 0, 0);
                    
                    if (fechaSeleccionada < hoy) {
                        fechaInput.classList.add('is-invalid');
                        valido = false;
                    } else {
                        fechaInput.classList.remove('is-invalid');
                    }

                    // Validar hora
                    const horaInput = document.getElementById('hora');
                    if (!horaInput.value) {
                        horaInput.classList.add('is-invalid');
                        valido = false;
                    } else {
                        horaInput.classList.remove('is-invalid');
                    }

                    return valido;
                }

                // Validación en tiempo real
                document.getElementById('fecha').addEventListener('change', function() {
                    const fechaSeleccionada = new Date(this.value);
                    const hoy = new Date();
                    hoy.setHours(0, 0, 0, 0);
                    
                    if (fechaSeleccionada < hoy) {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                    }
                });

                document.getElementById('hora').addEventListener('change', function() {
                    if (!this.value) {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                    }
                });
                </script>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer">
        <p>&copy; <?= date('Y') ?> Sistema de Gestión de Cursos - Todos los derechos reservados</p>
    </div>
</body>
</html>
