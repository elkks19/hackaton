<?php
include 'conexion.php';

// Validar que todos los campos requeridos están presentes
$required = ['id', 'nombre', 'descripcion', 'profesor_id', 'fecha_inicio', 'fecha_fin'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        die("El campo $field es requerido");
    }
}

// Validar y sanitizar datos
$id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
$nombre = trim($_POST['nombre']);
$descripcion = trim($_POST['descripcion']);
$profesor_id = filter_var($_POST['profesor_id'], FILTER_VALIDATE_INT);
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

// Validaciones específicas
if ($id === false || $id <= 0) {
    die("ID de curso inválido");
}

if (strlen($nombre) < 5 || strlen($nombre) > 100) {
    die("El nombre del curso debe tener entre 5 y 100 caracteres");
}

if (strlen($descripcion) < 10 || strlen($descripcion) > 500) {
    die("La descripción debe tener entre 10 y 500 caracteres");
}

if ($profesor_id === false || $profesor_id <= 0) {
    die("ID de profesor inválido");
}

// Verificar que el profesor existe
$check = $conn->prepare("SELECT id FROM usuarios WHERE id = ?");
$check->execute([$profesor_id]);
if ($check->rowCount() === 0) {
    die("El profesor seleccionado no existe");
}

// Validar fechas
if (!strtotime($fecha_inicio) || !strtotime($fecha_fin)) {
    die("Fechas inválidas");
}

if (strtotime($fecha_fin) < strtotime($fecha_inicio)) {
    die("La fecha de fin no puede ser anterior a la fecha de inicio");
}

// Verificar que el curso existe
$check = $conn->prepare("SELECT id FROM cursos WHERE id = ?");
$check->execute([$id]);
if ($check->rowCount() === 0) {
    die("El curso no existe");
}

// Actualizar en la base de datos
$sql = "UPDATE cursos SET nombre=?, descripcion=?, profesor_id=?, fecha_inicio=?, fecha_fin=?, updated_at=NOW() WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute([
    $nombre,
    $descripcion,
    $profesor_id,
    $fecha_inicio,
    $fecha_fin,
    $id
]);

// Actualizar los estudiantes asignados
if (isset($_POST['estudiantes']) && is_array($_POST['estudiantes'])) {
    $estudiantes = $_POST['estudiantes'];

    // Eliminar los estudiantes previamente asignados a este curso
    $delete = $conn->prepare("DELETE FROM estudiantes_curso WHERE curso_id = ?");
    $delete->execute([$id]);

    // Asignar los nuevos estudiantes seleccionados
    $insert = $conn->prepare("INSERT INTO estudiantes_curso (curso_id, estudiante_id) VALUES (?, ?)");

    foreach ($estudiantes as $estudiante_id) {
        $insert->execute([$id, $estudiante_id]);
    }
}

// Redirigir al índice después de la actualización
header("Location: index.php");
exit;
?>
