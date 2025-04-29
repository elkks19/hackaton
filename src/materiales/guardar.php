<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conexion = Connection::get();

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];

if ($_POST['tipo_id'] === 'nuevo') {
    $nuevo_tipo = trim($_POST['nuevo_tipo']);
    // Verificamos si ya existe
    $verificar = $conexion->prepare("SELECT id FROM tipos_materiales WHERE nombre = '{$nuevo_tipo}'");
    $verificar->execute();

    if ($verificar->rowCount() > 0) {
        $row = $verificar->fetchAll();
        $tipo_id = $row['id'];
    } else {
        $insertar_tipo = $conexion->prepare("INSERT INTO tipos_materiales (nombre) VALUES ('{$nuevo_tipo}')");
        $insertar_tipo->execute();
        $tipo_id = $conexion->lastInsertId();
    }
} else {
    $tipo_id = $_POST['tipo_id'];
}

$insertar_material = $conexion->prepare("INSERT INTO materiales (tipo_id, nombre, descripcion) VALUES ({$tipo_id}, '{$nombre}', '{$descripcion}')");
$insertar_material->execute();

header('Location: index.php');
?>
