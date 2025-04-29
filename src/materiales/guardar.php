<?php
require '../../conexion.php';

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];

if ($_POST['tipo_id'] === 'nuevo') {
    $nuevo_tipo = trim($_POST['nuevo_tipo']);
    
    // Verificamos si ya existe
    $verificar = $conexion->prepare("SELECT id FROM tipos_materiales WHERE nombre = ?");
    $verificar->bind_param("s", $nuevo_tipo);
    $verificar->execute();
    $resultado = $verificar->get_result();

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $tipo_id = $row['id'];
    } else {
        $insertar_tipo = $conexion->prepare("INSERT INTO tipos_materiales (nombre) VALUES (?)");
        $insertar_tipo->bind_param("s", $nuevo_tipo);
        $insertar_tipo->execute();
        $tipo_id = $conexion->insert_id;
    }
} else {
    $tipo_id = $_POST['tipo_id'];
}

$insertar_material = $conexion->prepare("INSERT INTO materiales (tipo_id, nombre, descripcion) VALUES (?, ?, ?)");
$insertar_material->bind_param("iss", $tipo_id, $nombre, $descripcion);
$insertar_material->execute();

header('Location: index.php');
?>
