<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Estudiantes</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --accent-color: #e74c3c;
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }
        
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        h1 {
            color: var(--primary-color);
            font-size: 28px;
        }
        
        .nav-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: var(--light-text);
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        .btn-delete {
            background-color: var(--accent-color);
        }
        
        .btn-delete:hover {
            background-color: #c0392b;
        }
        
        .search-container {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        
        .search-container input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 16px;
        }
        
        .search-container button {
            padding: 10px 15px;
            background-color: var(--primary-color);
            color: var(--light-text);
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: var(--box-shadow);
            border-radius: var(--border-radius);
            overflow: hidden;
        }
        
        thead {
            background-color: var(--primary-color);
            color: var(--light-text);
        }
        
        th, td {
            padding: 15px;
            text-align: left;
        }
        
        th {
            font-weight: 600;
        }
        
        tbody tr:nth-child(even) {
            background-color: var(--light-bg);
        }
        
        tbody tr:hover {
            background-color: rgba(52, 152, 219, 0.1);
        }
        
        .actions {
            display: flex;
            gap: 8px;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 14px;
        }
        
        .btn-view {
            background-color: #2ecc71;
        }
        
        .btn-view:hover {
            background-color: #27ae60;
        }
        
        .btn-edit {
            background-color: #f39c12;
        }
        
        .btn-edit:hover {
            background-color: #e67e22;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #777;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
        
        @media (max-width: 768px) {
            .nav-buttons {
                flex-direction: column;
            }
            
            .actions {
                flex-direction: column;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <?php
    include 'conexion.php';

    // Solo estudiantes NO eliminados
    $resultado = $conexion->query("SELECT * FROM estudiantes WHERE deleted_at IS NULL");
    $total_estudiantes = $resultado->num_rows;
    ?>

    <div class="container">
        <header>
            <h1><i class="fas fa-graduation-cap"></i> Sistema de Gestión de Estudiantes</h1>
            <div>
                <span class="date-display"><?php echo date('d/m/Y'); ?></span>
            </div>
        </header>

        <div class="nav-buttons">
            <a href="crear_estudiante.php" class="btn">
                <i class="fas fa-plus"></i> Crear Nuevo Estudiante
            </a>
            <a href="eliminados.php" class="btn btn-delete">
                <i class="fas fa-trash-alt"></i> Ver Estudiantes Eliminados
            </a>
        </div>

        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Buscar estudiantes...">
            <button id="searchButton"><i class="fas fa-search"></i></button>
        </div>

        <div class="table-container">
            <h2>Listado de Estudiantes Activos (<?php echo $total_estudiantes; ?>)</h2>
            
            <?php if ($total_estudiantes > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>CI</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($fila = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $fila['id']; ?></td>
                                <td><?php echo $fila['nombres'] . ' ' . $fila['apellidos']; ?></td>
                                <td><?php echo $fila['ci']; ?></td>
                                <td><?php echo $fila['telefono']; ?></td>
                                <td class="actions">
                                    <a href="ver_estudiante.php?id=<?php echo $fila['id']; ?>" class="btn btn-sm btn-view">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                    <a href="actualizar_estudiante.php?id=<?php echo $fila['id']; ?>" class="btn btn-sm btn-edit">
                                        <i class="fas fa-pencil-alt"></i> Editar
                                    </a>
                                    <a href="eliminar_estudiante.php?id=<?php echo $fila['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar a este estudiante?');" class="btn btn-sm btn-delete">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-users" style="font-size: 48px; margin-bottom: 15px;"></i>
                    <p>No hay estudiantes registrados actualmente.</p>
                    <p>Crea un nuevo estudiante para comenzar.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="footer">
            <p>© <?php echo date('Y'); ?> Sistema de Gestión de Estudiantes</p>
        </div>
    </div>

    <script>
        // Script para la funcionalidad de búsqueda
        document.getElementById('searchButton').addEventListener('click', function() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if(text.includes(input)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Buscar también al presionar Enter
        document.getElementById('searchInput').addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                document.getElementById('searchButton').click();
            }
        });
    </script>
</body>
</html>