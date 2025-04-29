<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conn = Connection::get();

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM clases WHERE id = ? AND deleted_at IS NULL");
$stmt->execute([$id]);
$clase = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$clase) {
    die("Clase no encontrada");
}

$cursos = $conn->query("SELECT id, nombre FROM cursos WHERE deleted_at IS NULL")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Clase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #FF7F27;
            --secondary-color: #FFA347;
            --accent-color: #FF5A00;
            --light-color: #FFF8F0;
            --dark-color: #333333;
        }
        
        body {
            background-color: var(--light-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
            font-weight: 600;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--dark-color);
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #e2e2e2;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(255, 127, 39, 0.25);
        }
        
        .is-invalid {
            border-color: #dc3545 !important;
        }
        
        .invalid-feedback {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }
        
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover, .btn-secondary:focus {
            background-color: #5a6268;
            border-color: #5a6268;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .footer {
            background-color: var(--primary-color);
            color: white;
            padding: 20px 0;
            margin-top: 50px;
            text-align: center;
            font-size: 14px;
        }
        
        @media (max-width: 768px) {
            .card-body {
                padding: 20px 15px;
            }
            
            .form-control, .form-select {
                padding: 10px 12px;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-graduation-cap me-2"></i>
                Sistema de Gestión de Clases
            </a>
        </div>
    </nav>
    
    <div class="main-container mt-4">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Clase</h4>
            </div>
            <div class="card-body">
                <form action="actualizar.php" method="POST" onsubmit="return validarFormulario()">
                    <input type="hidden" name="id" value="<?= $clase['id'] ?>">
                    
                    <div class="form-group">
                        <label for="curso_id" class="form-label">Curso</label>
                        <select id="curso_id" name="curso_id" class="form-select" required>
                            <?php foreach($cursos as $c): ?>
                                <option value="<?= $c['id'] ?>" <?= $c['id'] == $clase['curso_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($c['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" id="fecha" name="fecha" value="<?= $clase['fecha'] ?>" class="form-control" required>
                        <div class="invalid-feedback">La fecha no puede ser anterior al día de hoy</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="hora" class="form-label">Hora</label>
                        <input type="time" id="hora" name="hora" value="<?= $clase['hora'] ?>" class="form-control" required>
                        <div class="invalid-feedback">Por favor ingresa una hora válida</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="estado" class="form-label">Estado</label>
                        <select id="estado" name="estado" class="form-select" required>
                            <?php foreach(['REALIZADA','POSPUESTA','CANCELADA','SUSPENDIDA'] as $estado): ?>
                                <option <?= $estado == $clase['estado'] ? 'selected' : '' ?>><?= $estado ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="d-flex justify-content-start mt-4">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-save me-2"></i>Actualizar
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <footer class="footer">
        <div class="container">
            <p class="mb-0">&copy; <?= date('Y') ?> Sistema de Gestión de Clases. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function validarFormulario() {
        let valido = true;
        
        // Validar fecha
        
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
</body>
</html>
