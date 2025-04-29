<?php
require '../../conexion.php';


$nombre = $_POST['nombre'];
$conexion->query("INSERT INTO tipos_materiales (nombre) VALUES ('$nombre')");

header('Location: index.php');
