<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conexion = Connection::get();

$id = $_GET['id'];

$sql = "UPDATE usuarios SET deleted_at = CURRENT_TIMESTAMP WHERE id = $id";

if ($conexion->query($sql) !== false) {
	header("Location: usuarios.php");
	return;
} else {
	header("Location: usuarios.php");
	return;
}
?>
