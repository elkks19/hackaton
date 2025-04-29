<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conexion = Connection::get();

$resultado = $conexion->query("
    SELECT usuarios.*, roles.nombre AS rol_nombre 
    FROM usuarios 
    INNER JOIN roles ON usuarios.rol_id = roles.id
    WHERE usuarios.deleted_at IS NOT NULL
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios Eliminados</title>
</head>
<body>

<h1>Listado de Usuarios Eliminados</h1>

<a href="usuarios.php">
    <button>🔙 Volver a Activos</button>
</a>

<br><br>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre Completo</th>
            <th>Rol</th>
            <th>CI</th>
            <th>Teléfono</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo $fila['id']; ?></td>
                <td><?php echo $fila['nombres'] . ' ' . $fila['apellidos']; ?></td>
                <td><?php echo $fila['rol_nombre']; ?></td>
                <td><?php echo $fila['ci']; ?></td>
                <td><?php echo $fila['telefono']; ?></td>
                <td>
                    <a href="restaurar_usuario.php?id=<?php echo $fila['id']; ?>" onclick="return confirm('¿Seguro de restaurar este usuario?');">
                        <button>♻️ Restaurar</button>
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
