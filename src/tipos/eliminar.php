<?php
require '../../conexion.php';


$id = $_GET['id'];
$conexion->query("DELETE FROM tipos_materiales WHERE id = $id");

header('Location: index.php');
