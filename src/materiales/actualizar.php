<?php
require '../../conexion.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$tipo_id = $_POST['tipo_id'];

$conexion->query("
    UPDATE materiales 
    SET nombre = '$nombre', descripcion = '$descripcion', tipo_id = $tipo_id, updated_at = NOW() 
    WHERE id = $id
");

header('Location: index.php');
