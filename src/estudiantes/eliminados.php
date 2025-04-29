<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conexion = Connection::get();
$resultado = $conexion->query("SELECT * FROM estudiantes WHERE deleted_at IS NOT NULL");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiantes Eliminados</title>
    <style>
        :root {
            --primary: #4F46E5;
            --primary-dark: #4338CA;
            --success: #10B981;
            --danger: #EF4444;
            --text: #1F2937;
            --text-light: #6B7280;
            --background: #F9FAFB;
            --border: #E5E7EB;
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
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }
        
        .header h1 {
            color: var(--primary);
            font-size: 1.8rem;
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
        
        .btn-success {
            background-color: var(--success);
            color: white;
        }
        
        .btn-success:hover {
            background-color: #0EA271;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        }
        
        .table-container {
            overflow-x: auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background-color: #F3F4F6;
        }
        
        th {
            text-align: left;
            padding: 1rem;
            font-weight: 600;
            color: var(--text);
            border-bottom: 2px solid var(--border);
        }
        
        td {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        tr:hover {
            background-color: #F9FAFB;
        }
        
        .empty-state {
            padding: 3rem;
            text-align: center;
            color: var(--text-light);
        }
        
        .footer {
            margin-top: 2rem;
            text-align: center;
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            th, td {
                padding: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Listado de Estudiantes Eliminados</h1>
            <a href="estudiante.php" class="btn btn-primary">
                <span>🔙</span> Volver al Listado Activo
            </a>
        </div>
        
        <div class="table-container">
            <?php if ($resultado->rowCount()> 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>CI</th>
                            <th>Teléfono</th>
                            <th>Fecha Eliminación</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultado->fetchAll() as $fila): ?>
                            <tr>
                                <td><?php echo $fila['id']; ?></td>
                                <td><?php echo $fila['nombres'] . ' ' . $fila['apellidos']; ?></td>
                                <td><?php echo $fila['ci']; ?></td>
                                <td><?php echo $fila['telefono']; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($fila['deleted_at'])); ?></td>
                                <td>
                                    <a href="restaurar_estudiante.php?id=<?php echo $fila['id']; ?>" 
                                       onclick="return confirm('¿Está seguro de restaurar este estudiante?');"
                                       class="btn btn-success" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                                        Restaurar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <p>No hay estudiantes eliminados en este momento.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="footer">
            <p>© <?php echo date('Y'); ?> Sistema de Gestión Estudiantil</p>
        </div>
    </div>
</body>
</html>
