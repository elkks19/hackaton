<?php
session_start();

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conn = Connection::get();

// Inicializar array de errores
$_SESSION['errors'] = [];

// Validar que todos los campos requeridos están presentes
$required = ['nombre', 'descripcion', 'profesor_id', 'fecha_inicio', 'fecha_fin'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        $_SESSION['errors'][$field] = "El campo $field es requerido";
    }
}

// Validar y sanitizar datos
$nombre = trim($_POST['nombre']);
$descripcion = trim($_POST['descripcion']);
$profesor_id = filter_var($_POST['profesor_id'], FILTER_VALIDATE_INT);
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

// Validaciones específicas
if (strlen($nombre) < 5 || strlen($nombre) > 100) {
    $_SESSION['errors']['nombre'] = "El nombre del curso debe tener entre 5 y 100 caracteres";
}

if (strlen($descripcion) < 10 || strlen($descripcion) > 500) {
    $_SESSION['errors']['descripcion'] = "La descripción debe tener entre 10 y 500 caracteres";
}

if ($profesor_id === false || $profesor_id <= 0) {
    $_SESSION['errors']['profesor_id'] = "ID de profesor inválido";
} else {
    // Verificar que el profesor existe
    $check = $conn->prepare("SELECT id FROM usuarios WHERE id = ?");
    $check->execute([$profesor_id]);
    if ($check->rowCount() === 0) {
        $_SESSION['errors']['profesor_id'] = "El profesor seleccionado no existe";
    }
}

// Validar fechas
if (!strtotime($fecha_inicio) || !strtotime($fecha_fin)) {
    $_SESSION['errors']['fecha_inicio'] = "Fechas inválidas";
} elseif (strtotime($fecha_fin) < strtotime($fecha_inicio)) {
    $_SESSION['errors']['fecha_fin'] = "La fecha de fin no puede ser anterior a la fecha de inicio";
}

// Guardar los valores del formulario para repoblarlo
$_SESSION['old_input'] = $_POST;

// Si hay errores, redirigir de vuelta al formulario
if (!empty($_SESSION['errors'])) {
    header("Location: crear.php");
    exit;
}

// Si no hay errores, insertar en la base de datos
$sql = "INSERT INTO cursos (nombre, descripcion, profesor_id, fecha_inicio, fecha_fin, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
$stmt = $conn->prepare($sql);
$stmt->execute([
    $nombre,
    $descripcion,
    $profesor_id,
    $fecha_inicio,
    $fecha_fin
]);

// Limpiar datos de sesión después de éxito
unset($_SESSION['errors']);
unset($_SESSION['old_input']);

header("Location: index.php");
exit;
?>
