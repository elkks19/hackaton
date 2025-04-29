<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eliminar Estudiante</title>
    <style>
        :root {
            --primary: #4F46E5;
            --primary-dark: #4338CA;
            --success: #10B981;
            --danger: #EF4444;
            --text: #1F2937;
            --text-light: #6B7280;
            --background: #F9FAFB;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background);
            color: var(--text);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        
        .container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            text-align: center;
        }
        
        .header {
            margin-bottom: 2rem;
        }
        
        h1 {
            color: var(--primary);
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
        
        .content {
            margin: 2rem 0;
        }
        
        .status {
            padding: 1rem;
            border-radius: 8px;
            margin: 1.5rem 0;
        }
        
        .status.success {
            background-color: rgba(16, 185, 129, 0.1);
            border-left: 4px solid var(--success);
            color: var(--success);
        }
        
        .status.error {
            background-color: rgba(239, 68, 68, 0.1);
            border-left: 4px solid var(--danger);
            color: var(--danger);
        }
        
        .btn {
            display: inline-block;
            text-decoration: none;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
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
        
        .footer {
            margin-top: 1.5rem;
            color: var(--text-light);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Sistema de Gestión Estudiantil</h1>
            <p>Panel de eliminacion de registros</p>
        </div>
        
        <div class="content">
            <?php
			require_once __DIR__ . '/../index.php';

			use App\DB\Connection;

			$conexion = Connection::get();


            $id = $_GET['id'];

            // Restaurar estudiante: poner deleted_at en NULL
            $sql = "UPDATE estudiantes SET deleted_at = CURRENT_TIMESTAMP WHERE id = $id";

        	if ($conexion->query($sql) !== false) {
                echo "<div class='status success'>
                        <strong>¡Éxito!</strong> El estudiante ha sido eliminado correctamente.
                      </div>";
            } else {
                echo "<div class='status error'>
                        <strong>Error:</strong> " . $conexion->errorInfo()[2] . "
                      </div>";
            }
            ?>
        </div>
        
        <a href="estudiante.php" class="btn btn-primary">Volver al listado</a>
        
        <div class="footer">
            <p>© <?php echo date('Y'); ?> Sistema de Gestión Estudiantil</p>
        </div>
    </div>
</body>
</html>
