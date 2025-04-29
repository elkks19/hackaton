<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conn = Connection::get();

// Validaciones
if (empty($_POST['id']) || empty($_POST['curso_id']) || empty($_POST['fecha']) || empty($_POST['hora']) || empty($_POST['estado'])) {
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

$sql = "UPDATE clases SET curso_id = ?, fecha = ?, hora = ?, estado = ?, updated_at = NOW() WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([
    $_POST['curso_id'],
    $_POST['fecha'],
    $_POST['hora'],
    $_POST['estado'],
    $_POST['id']
]);

header("Location: index.php");
exit();
?>
