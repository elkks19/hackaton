<?php
include 'conexion.php';

$id = $_GET['id'];

// Restaurar estudiante: poner deleted_at en NULL
$sql = "UPDATE estudiantes SET deleted_at = NULL, updated_at = CURRENT_TIMESTAMP WHERE id = $id";

if ($conexion->query($sql) === TRUE) {
    echo "Estudiante restaurado correctamente.";
} else {
    echo "Error al restaurar: " . $conexion->error;
}
?>
<a href="eliminados.php">Volver al listado de eliminados</a>
