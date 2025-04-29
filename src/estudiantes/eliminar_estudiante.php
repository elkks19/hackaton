<?php
include 'conexion.php';

$id = $_GET['id'];

$sql = "UPDATE estudiantes SET deleted_at = CURRENT_TIMESTAMP WHERE id = $id";

if ($conexion->query($sql) === TRUE) {
    echo "Estudiante eliminado lógicamente.";
} else {
    echo "Error al eliminar: " . $conexion->error;
}
?>
<a href="estudiante.php">Volver al listado</a>
