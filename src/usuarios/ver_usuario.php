<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conexion = Connection::get();

$id = $_GET['id'];

// Mejor práctica: usar consultas preparadas para evitar inyección SQL
$stmt = $conexion->prepare("
    SELECT usuarios.*, roles.nombre AS rol_nombre 
    FROM usuarios 
    INNER JOIN roles ON usuarios.rol_id = roles.id
    WHERE usuarios.id = {$id}
");
$stmt->execute();
$resultado = $stmt->fetch();

if ($resultado->rowCount() > 0) {
    $fila = $resultado->fetch();
} else {
    echo "Usuario no encontrado.";
    exit;
}

$titulo = "Detalle del Usuario";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #ff7f2a;     /* Naranja principal */
--primary-hover: #e86b1c;     /* Naranja principal más oscuro para hover */
--danger-color: #ff5252;      /* Rojo-naranja para acciones peligrosas */
--danger-hover: #e64545;      /* Rojo-naranja más oscuro para hover */
--success-color: #ff9f45;     /* Naranja-amarillo para acciones exitosas */
--success-hover: #e68f3a;     /* Naranja-amarillo más oscuro para hover */
--gray-light: #fff5ec;        /* Gris claro con tinte naranja */
--gray-medium: #f2e2d2;       /* Gris medio con tinte naranja */
--gray-dark: #7d6e63;         /* Gris oscuro con tinte naranja/marrón */
--border-radius: 8px;         /* Sin cambios */
--box-shadow: 0 4px 6px rgba(230, 126, 34, 0.15); /* Sombra con tono naranja */
--transition: all 0.3s ease;  /* Sin cambios */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header h1 {
            color: #333;
            font-size: 1.8rem;
            margin: 0;
        }

        .user-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .user-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-header h2 {
            margin: 0;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-body {
            padding: 1.5rem;
        }

        .user-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .info-group {
            margin-bottom: 1rem;
        }

        .info-label {
            font-weight: 600;
            color: var(--gray-dark);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 1.1rem;
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--gray-medium);
        }

        .info-value:last-child {
            border-bottom: none;
        }

        .rol-badge {
            background-color: var(--primary-color);
            color: white;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-block;
        }

        .action-buttons {
            margin-top: 2rem;
            display: flex;
            gap: 1rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-edit {
            background-color: var(--success-color);
        }

        .btn-edit:hover {
            background-color: var(--success-hover);
        }

        .btn-delete {
            background-color: var(--danger-color);
        }

        .btn-delete:hover {
            background-color: var(--danger-hover);
        }

        .footer {
            text-align: center;
            padding: 1.5rem 0;
            color: var(--gray-dark);
            font-size: 0.9rem;
            border-top: 1px solid var(--gray-medium);
            margin-top: 2rem;
        }

        @media screen and (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .user-info {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
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
        <h1><?php echo $titulo; ?></h1>
    </div>

    <div class="user-card">
        <div class="user-header">
            <h2>
                <i class="fas fa-user-circle"></i>
                <?php echo $fila['nombres'] . ' ' . $fila['apellidos']; ?>
            </h2>
            <span class="rol-badge"><?php echo $fila['rol_nombre']; ?></span>
        </div>
        
        <div class="user-body">
            <div class="user-info">
                <div>
                    <div class="info-group">
                        <div class="info-label">ID</div>
                        <div class="info-value"><?php echo $fila['id']; ?></div>
                    </div>
                    
                    <div class="info-group">
                        <div class="info-label">Nombres</div>
                        <div class="info-value"><?php echo $fila['nombres']; ?></div>
                    </div>
                    
                    <div class="info-group">
                        <div class="info-label">Apellidos</div>
                        <div class="info-value"><?php echo $fila['apellidos']; ?></div>
                    </div>
                    
                    <div class="info-group">
                        <div class="info-label">Cédula de Identidad</div>
                        <div class="info-value"><?php echo $fila['ci']; ?></div>
                    </div>
                </div>
                
                <div>
                    <div class="info-group">
                        <div class="info-label">Teléfono</div>
                        <div class="info-value"><?php echo $fila['telefono']; ?></div>
                    </div>
                    
                    <div class="info-group">
                        <div class="info-label">Dirección</div>
                        <div class="info-value"><?php echo $fila['direccion']; ?></div>
                    </div>
                    
                    <div class="info-group">
                        <div class="info-label">Fecha de nacimiento</div>
                        <div class="info-value"><?php echo $fila['fecha_nacimiento']; ?></div>
                    </div>
                </div>
            </div>
            
            <div class="action-buttons">
                <a href="usuarios.php" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Volver al listado
                </a>
                <a href="actualizar_usuario.php?id=<?php echo $fila['id']; ?>" class="btn btn-edit">
                    <i class="fas fa-pencil-alt"></i> Editar usuario
                </a>
                <a href="eliminar_usuario.php?id=<?php echo $fila['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar a este usuario?');" class="btn btn-delete">
                    <i class="fas fa-trash"></i> Eliminar usuario
                </a>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>© <?php echo date('Y'); ?> Sistema de Gestión de Usuarios</p>
    </div>
</div>

</body>
</html>
