<?php
include 'conexion.php';

$resultado = $conexion->query("SELECT * FROM roles");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Roles</title>
</head>
<body>

<h1>Listado de Roles</h1>

<a href="crear_rol.php">
    <button>➕ Crear Nuevo Rol</button>
</a>

<br><br>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre del Rol</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo $fila['id']; ?></td>
                <td><?php echo $fila['nombre']; ?></td>
                <td>
                    <a href="actualizar_rol.php?id=<?php echo $fila['id']; ?>">
                        <button>✏️ Editar</button>
                    </a>
                    <a href="eliminar_rol.php?id=<?php echo $fila['id']; ?>" onclick="return confirm('¿Seguro de eliminar este rol?');">
                        <button>🗑️ Eliminar</button>
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
