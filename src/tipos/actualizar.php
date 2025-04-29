<?php
require '../../conexion.php';


$id = $_POST['id'];
$nombre = $_POST['nombre'];

$conexion->query("UPDATE tipos_materiales SET nombre = '$nombre' WHERE id = $id");

header('Location: index.php');
