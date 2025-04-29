<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if ($id === false || $id <= 0) {
        die("ID de curso inválido");
    }
    
    // Verificar que el curso existe y no está ya eliminado
    $check = $conn->prepare("SELECT id FROM cursos WHERE id = ? AND deleted_at IS NULL");
    $check->execute([$id]);
    if ($check->rowCount() === 0) {
        die("El curso no existe o ya está inactivo");
    }

    // Marcar como eliminado (actualiza el campo deleted_at)
    $sql = "UPDATE cursos SET deleted_at = NOW() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    header("Location: index.php");
    exit();
} else {
    die("ID de curso no proporcionado.");
}
?>