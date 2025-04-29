<?php
require '../../conexion.php';

$tipo_id = $_POST['tipo_id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];

$conexion->query("INSERT INTO materiales (tipo_id, nombre, descripcion) VALUES ('$tipo_id', '$nombre', '$descripcion')");

header('Location: index.php');
