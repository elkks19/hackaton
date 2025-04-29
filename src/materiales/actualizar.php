<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conexion = Connection::get();

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$tipo_id = $_POST['tipo_id'];
$nuevo_tipo = trim($_POST['nuevo_tipo']); // Este es el campo opcional para el nuevo tipo

// Si el usuario ingresó un nuevo tipo de material
if (!empty($nuevo_tipo)) {
    // Insertamos el nuevo tipo
    $stmt = $conexion->prepare("INSERT INTO tipos_materiales (nombre) VALUES (?)");
    $stmt->bindParam("s", $nuevo_tipo);
    $stmt->execute();
    $tipo_id = $conexion->lastInsertId(); // Reemplazamos el tipo_id con el nuevo insertado
}

$conexion->query("
    UPDATE materiales 
    SET nombre = '$nombre', descripcion = '$descripcion', tipo_id = $tipo_id, updated_at = NOW() 
    WHERE id = $id
");

header('Location: index.php');
