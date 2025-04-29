<?php
include 'conexion.php';

$id = $_GET['id'];

$sql = "DELETE FROM roles WHERE id=$id";

if ($conexion->query($sql) === TRUE) {
    echo "Rol eliminado correctamente.";
} else {
    echo "Error al eliminar: " . $conexion->error;
}
?>
<a href="roles.php">Volver al listado</a>
