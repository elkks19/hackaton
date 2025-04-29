<?php
include 'conexion.php';

$id = $_GET['id'];

$sql = "UPDATE usuarios SET deleted_at = CURRENT_TIMESTAMP WHERE id = $id";

if ($conexion->query($sql) === TRUE) {
    echo "Usuario eliminado lógicamente.";
} else {
    echo "Error al eliminar: " . $conexion->error;
}
?>
<a href="usuarios.php">Volver al listado</a>
