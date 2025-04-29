<?php
include 'conexion.php';

// Validaciones
if (empty($_POST['curso_id']) || empty($_POST['fecha']) || empty($_POST['hora']) || empty($_POST['estado'])) {
    die("Todos los campos son requeridos");
}

// Validar que la fecha no sea anterior a hoy
$fechaActual = new DateTime();
$fechaClase = new DateTime($_POST['fecha']);

if ($fechaClase < $fechaActual) {
    die("La fecha de la clase no puede ser anterior al día actual");
}

// Validar que el estado sea uno de los permitidos
$estadosPermitidos = ['REALIZADA', 'POSPUESTA', 'CANCELADA', 'SUSPENDIDA'];
if (!in_array($_POST['estado'], $estadosPermitidos)) {
    die("Estado de clase no válido");
}

$sql = "INSERT INTO clases (curso_id, fecha, hora, estado, created_at, updated_at)
        VALUES (?, ?, ?, ?, NOW(), NOW())";

$stmt = $conn->prepare($sql);
$stmt->execute([
    $_POST['curso_id'],
    $_POST['fecha'],
    $_POST['hora'],
    $_POST['estado']
]);

header("Location: index.php");
exit();
?>