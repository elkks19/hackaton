<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conexion = Connection::get();

$id = $_GET['id'];

$sql = "UPDATE usuarios SET deleted_at = CURRENT_TIMESTAMP WHERE id = $id";

if ($conexion->query($sql) === TRUE) {
    echo "Usuario eliminado lógicamente.";
} else {
    echo "Error al eliminar: " . $conexion->error;
}
?>
<a href="usuarios.php">Volver al listado</a>
