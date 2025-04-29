<?php
include 'conexion.php';

$resultado = $conexion->query("
    SELECT usuarios.*, roles.nombre AS rol_nombre 
    FROM usuarios 
    INNER JOIN roles ON usuarios.rol_id = roles.id
    WHERE usuarios.deleted_at IS NOT NULL
");

// Contar usuarios eliminados
$total_eliminados = $resultado->num_rows;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Eliminados</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #ff7d36;
            --primary-hover: #e66b28;
            --danger-color: #ff4d4d;
            --danger-hover: #e63939;
            --success-color: #4adc7d;
            --success-hover: #3dbe69;
            --warning-color: #ffb74d;
            --warning-hover: #e6a642;
            --gray-light: #fff5eb;
            --gray-medium: #ffe0cc;
            --gray-dark: #996033;
            --text-dark: #5a3a20;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(255, 125, 54, 0.15);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f9f2ec;
            color: var(--text-dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .title-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .title-container h1 {
            margin: 0;
            font-size: 1.8rem;
            color: var(--text-dark);
        }
        
        .title-container .counter {
            background-color: var(--danger-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .nav-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: var(--transition);
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
        }

        .btn-restore {
            background-color: var(--warning-color);
        }

        .btn-restore:hover {
            background-color: var(--warning-hover);
        }

        .btn-success {
            background-color: var(--success-color);
        }

        .btn-success:hover {
            background-color: var(--success-hover);
        }

        .btn-sm {
            padding: 0.35rem 0.7rem;
            font-size: 0.85rem;
        }

        .table-container {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .table-header {
            background-color: var(--danger-color);
            color: white;
            padding: 1rem 1.5rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .table-header .trash-icon {
            font-size: 1.2rem;
            margin-right: 0.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid var(--gray-medium);
        }

        th {
            background-color: var(--gray-light);
            font-weight: 600;
            color: var(--text-dark);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: var(--gray-light);
        }

        .actions {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--gray-dark);
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--gray-medium);
            margin-bottom: 1rem;
            opacity: 0.7;
        }

        .empty-state p {
            margin: 0.5rem 0;
            font-size: 1.1rem;
        }

        .user-role {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            opacity: 0.8;
        }

        @media screen and (max-width: 768px) {
            .header-section {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .nav-buttons {
                width: 100%;
                margin-top: 1rem;
            }
            
            th, td {
                padding: 0.75rem;
            }
            
            .table-container {
                overflow-x: auto;
            }
            
            table {
                min-width: 600px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <div class="title-container">
                <h1>Usuarios Eliminados</h1>
                <span class="counter"><?php echo $total_eliminados; ?></span>
            </div>
            
            <div class="nav-buttons">
                <a href="usuarios.php" class="btn">
                    <i class="fas fa-user-check"></i> Usuarios Activos
                </a>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <span><i class="fas fa-trash-alt trash-icon"></i> Usuarios que han sido eliminados</span>
            </div>
            
            <?php if ($total_eliminados > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Rol</th>
                            <th>CI</th>
                            <th>Teléfono</th>
                            <th>Fecha Eliminación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($fila = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $fila['id']; ?></td>
                                <td><?php echo $fila['nombres'] . ' ' . $fila['apellidos']; ?></td>
                                <td>
                                    <span class="user-role"><?php echo $fila['rol_nombre']; ?></span>
                                </td>
                                <td><?php echo $fila['ci']; ?></td>
                                <td><?php echo $fila['telefono']; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($fila['deleted_at'])); ?></td>
                                <td class="actions">
                                    <a href="restaurar_usuario.php?id=<?php echo $fila['id']; ?>" 
                                       onclick="return confirm('¿Está seguro de restaurar este usuario?');" 
                                       class="btn btn-sm btn-restore" 
                                       title="Restaurar usuario">
                                        <i class="fas fa-trash-restore"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-trash-alt"></i>
                    <p>No hay usuarios eliminados</p>
                    <p>Todos los usuarios están activos en el sistema</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>