<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conexion = Connection::get();

$id = $_GET['id'];
$conexion->query("UPDATE materiales SET deleted_at = NOW() WHERE id = $id");

header('Location: index.php');
