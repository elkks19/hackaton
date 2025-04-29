<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Estudiante</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --accent-color: #e74c3c;
            --success-color: #2ecc71;
            --light-bg: #f8f9fa;
            --dark-text: #333;
            --light-text: #fff;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f4f7f9;
            color: var(--dark-text);
            line-height: 1.6;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }
        
        header {
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        h1 {
            color: var(--primary-color);
            font-size: 28px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }
        
        .section-title {
            margin: 30px 0 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            color: var(--secondary-color);
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 12px 24px;
            background-color: var(--primary-color);
            color: var(--light-text);
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        .btn-success {
            background-color: var(--success-color);
        }
        
        .btn-success:hover {
            background-color: #27ae60;
        }
        
        .btn-back {
            background-color: #95a5a6;
        }
        
        .btn-back:hover {
            background-color: #7f8c8d;
        }
        
        .actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        .alert {
            padding: 15px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            border-left: 4px solid transparent;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left-color: #28a745;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left-color: #dc3545;
        }
        
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .actions {
                flex-direction: column;
                gap: 15px;
            }
            
            .actions .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <?php
    include 'conexion.php';
    
    $mensaje = '';
    $tipo_mensaje = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $ci = $_POST['ci'];
        $telefono = $_POST['telefono'];
        $nombre_tutor = $_POST['nombre_tutor'];
        $telefono_tutor = $_POST['telefono_tutor'];
        $ci_tutor = $_POST['ci_tutor'];

        $sql = "INSERT INTO estudiantes (nombres, apellidos, ci, telefono, nombre_tutor, telefono_tutor, ci_tutor)
                VALUES ('$nombres', '$apellidos', '$ci', '$telefono', '$nombre_tutor', '$telefono_tutor', '$ci_tutor')";

        if ($conexion->query($sql) === TRUE) {
            $mensaje = "Estudiante registrado correctamente.";
            $tipo_mensaje = "success";
        } else {
            $mensaje = "Error: " . $conexion->error;
            $tipo_mensaje = "danger";
        }
    }
    ?>

    <div class="container">
        <header>
            <h1><i class="fas fa-user-plus"></i> Crear Nuevo Estudiante</h1>
        </header>
        
        <?php if($mensaje): ?>
            <div class="alert alert-<?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <h3 class="section-title">Información Personal</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="nombres">Nombres:</label>
                    <input type="text" id="nombres" name="nombres" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" class="form-control" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="ci">CI:</label>
                    <input type="text" id="ci" name="ci" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono" class="form-control" required>
                </div>
            </div>
            
            <h3 class="section-title">Información del Tutor</h3>
            
            <div class="form-group">
                <label for="nombre_tutor">Nombre del Tutor:</label>
                <input type="text" id="nombre_tutor" name="nombre_tutor" class="form-control" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="telefono_tutor">Teléfono del Tutor:</label>
                    <input type="text" id="telefono_tutor" name="telefono_tutor" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="ci_tutor">CI del Tutor:</label>
                    <input type="text" id="ci_tutor" name="ci_tutor" class="form-control">
                </div>
            </div>
            
            <div class="actions">
                <a href="estudiante.php" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i> Volver al listado
                </a>
                
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar Estudiante
                </button>
            </div>
        </form>
    </div>
</body>
</html>