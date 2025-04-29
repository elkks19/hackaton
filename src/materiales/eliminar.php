<?php
require '../../conexion.php';

$id = $_GET['id'];
$conexion->query("UPDATE materiales SET deleted_at = NOW() WHERE id = $id");

header('Location: index.php');
