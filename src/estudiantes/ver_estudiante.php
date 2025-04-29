<?php
include 'conexion.php';

$id = $_GET['id'];

$resultado = $conexion->query("SELECT * FROM estudiantes WHERE id = $id");

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
} else {
    echo "Estudiante no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Estudiante</title>
</head>
<body>

<h1>Detalle del Estudiante</h1>

<ul>
    <li><strong>ID:</strong> <?php echo $fila['id']; ?></li>
    <li><strong>Nombres:</strong> <?php echo $fila['nombres']; ?></li>
    <li><strong>Apellidos:</strong> <?php echo $fila['apellidos']; ?></li>
    <li><strong>CI:</strong> <?php echo $fila['ci']; ?></li>
    <li><strong>Teléfono:</strong> <?php echo $fila['telefono']; ?></li>
    <li><strong>Nombre del Tutor:</strong> <?php echo $fila['nombre_tutor']; ?></li>
    <li><strong>Teléfono del Tutor:</strong> <?php echo $fila['telefono_tutor']; ?></li>
    <li><strong>CI del Tutor:</strong> <?php echo $fila['ci_tutor']; ?></li>
    <li><strong>Fecha de Registro:</strong> <?php echo $fila['created_at']; ?></li>
</ul>

<a href="estudiante.php">
    <button>🔙 Volver al listado</button>
</a>

</body>
</html>
