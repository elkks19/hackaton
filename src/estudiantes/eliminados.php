<?php
include 'conexion.php';

// Solo estudiantes eliminados
$resultado = $conexion->query("SELECT * FROM estudiantes WHERE deleted_at IS NOT NULL");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estudiantes Eliminados</title>
</head>
<body>

<h1>Listado de Estudiantes Eliminados</h1>

<!-- Botón para volver al listado principal -->
<a href="estudiante.php">
    <button>🔙 Volver al Listado Activo</button>
</a>

<br><br>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre Completo</th>
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
                <td><?php echo $fila['ci']; ?></td>
                <td><?php echo $fila['telefono']; ?></td>
                <td>
                    <a href="restaurar_estudiante.php?id=<?php echo $fila['id']; ?>" onclick="return confirm('¿Seguro de restaurar este estudiante?');">
                        <button>♻️ Restaurar</button>
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
