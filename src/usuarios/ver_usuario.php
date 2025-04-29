<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conexion = Connection::get();

$id = $_GET['id'];

$resultado = $conexion->query("
    SELECT usuarios.*, roles.nombre AS rol_nombre 
    FROM usuarios 
    INNER JOIN roles ON usuarios.rol_id = roles.id
    WHERE usuarios.id = $id
");

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
} else {
    echo "Usuario no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Usuario</title>
</head>
<body>

<h1>Detalle del Usuario</h1>

<ul>
    <li><strong>ID:</strong> <?php echo $fila['id']; ?></li>
    <li><strong>Rol:</strong> <?php echo $fila['rol_nombre']; ?></li>
    <li><strong>Nombres:</strong> <?php echo $fila['nombres']; ?></li>
    <li><strong>Apellidos:</strong> <?php echo $fila['apellidos']; ?></li>
    <li><strong>CI:</strong> <?php echo $fila['ci']; ?></li>
    <li><strong>Teléfono:</strong> <?php echo $fila['telefono']; ?></li>
    <li><strong>Dirección:</strong> <?php echo $fila['direccion']; ?></li>
    <li><strong>Fecha de nacimiento:</strong> <?php echo $fila['fecha_nacimiento']; ?></li>
</ul>

<a href="usuarios.php">
    <button>🔙 Volver al listado</button>
</a>

</body>
</html>
