<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conexion = Connection::get();
$id = $_GET['id'];

$resultado = $conexion->query("SELECT * FROM estudiantes WHERE id = $id");

if ($resultado->rowCount()> 0) {
    $fila = $resultado->fetchAll();
} else {
    echo "<div style='text-align: center; margin-top: 50px;'>
            <h2 style='color: #EF4444;'>Estudiante no encontrado</h2>
            <a href='estudiante.php' style='display: inline-block; margin-top: 20px; background-color: #4F46E5; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Volver al listado</a>
          </div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Estudiante</title>
    <style>
        :root {
            --primary: #4F46E5;
            --primary-dark: #4338CA;
            --secondary: #6B7280;
            --success: #10B981;
            --danger: #EF4444;
            --text: #1F2937;
            --text-light: #6B7280;
            --background: #F9FAFB;
            --border: #E5E7EB;
            --card: #FFFFFF;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background);
            color: var(--text);
            padding: 2rem;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .header {
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .header h1 {
            color: var(--primary);
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .header p {
            color: var(--text-light);
        }
        
        .card {
            background-color: var(--card);
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .student-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .info-section {
            margin-bottom: 1.5rem;
        }
        
        .info-section h2 {
            color: var(--primary);
            font-size: 1.3rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--border);
        }
        
        .info-item {
            display: flex;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border);
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            min-width: 150px;
            color: var(--text);
        }
        
        .info-value {
            color: var(--text-light);
            flex: 1;
        }
        
        .actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            font-size: 1rem;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        }
        
        .btn-outline {
            background-color: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }
        
        .btn-outline:hover {
            background-color: rgba(79, 70, 229, 0.05);
            transform: translateY(-2px);
        }
        
        .footer {
            margin-top: 2rem;
            text-align: center;
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .student-info {
                grid-template-columns: 1fr;
            }
            
            .info-item {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .info-label {
                min-width: auto;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Detalle del Estudiante</h1>
            <p>Información completa del registro</p>
        </div>
        
        <div class="card">
            <div class="student-info">
                <div class="info-section">
                    <h2>Información Personal</h2>
                    <div class="info-item">
                        <div class="info-label">ID</div>
                        <div class="info-value"><?php echo $fila['id']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Nombres</div>
                        <div class="info-value"><?php echo $fila['nombres']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Apellidos</div>
                        <div class="info-value"><?php echo $fila['apellidos']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">CI</div>
                        <div class="info-value"><?php echo $fila['ci']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Teléfono</div>
                        <div class="info-value"><?php echo $fila['telefono']; ?></div>
                    </div>
                </div>
                
                <div class="info-section">
                    <h2>Información del Tutor</h2>
                    <div class="info-item">
                        <div class="info-label">Nombre</div>
                        <div class="info-value"><?php echo $fila['nombre_tutor']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Teléfono</div>
                        <div class="info-value"><?php echo $fila['telefono_tutor']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">CI</div>
                        <div class="info-value"><?php echo $fila['ci_tutor']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Fecha de Registro</div>
                        <div class="info-value"><?php echo date('d/m/Y H:i', strtotime($fila['created_at'])); ?></div>
                    </div>
                </div>
            </div>
            
            <div class="actions">
                <a href="estudiante.php" class="btn btn-primary">
                    <span>🔙</span> Volver al listado
                </a>
                <a href="actualizar_estudiante.php?id=<?php echo $fila['id']; ?>" class="btn btn-outline">
                    <span>✏️</span> Editar información
                </a>
            </div>
        </div>
        
        <div class="footer">
            <p>© <?php echo date('Y'); ?> Sistema de Gestión Estudiantil</p>
        </div>
    </div>
</body>
</html>
