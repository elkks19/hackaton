<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conexion = Connection::get();

$id = $_GET['id'];

$sql = "UPDATE usuarios SET deleted_at = NULL, updated_at = CURRENT_TIMESTAMP WHERE id = $id";

if ($conexion->query($sql) !== false) {
	header("Location: usuarios_eliminados.php");
	return;
} else {
	header("Location: usuarios_eliminados.php");
	return;
}
?>
<a href="usuarios_eliminados.php">Volver al listado de eliminados</a>

