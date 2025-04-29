<?php
include 'conexion.php';

// Verificar que llegaron datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clase_id = $_POST['clase_id'];
    $profesor_id = $_POST['profesor_id'];
    $asistencia = isset($_POST['asistencia']) ? true : false;

    if ($asistencia) {
        // Verificar si ya existe asistencia para evitar duplicados
        $stmt = $pdo->prepare("
            SELECT * FROM asistencia_profesores 
            WHERE clase_id = :clase_id AND profesor_id = :profesor_id
        ");
        $stmt->execute([
            'clase_id' => $clase_id,
            'profesor_id' => $profesor_id
        ]);

        if ($stmt->rowCount() == 0) {
            // Insertar asistencia
            $insert = $pdo->prepare("
                INSERT INTO asistencia_profesores (clase_id, profesor_id) 
                VALUES (:clase_id, :profesor_id)
            ");
            $insert->execute([
                'clase_id' => $clase_id,
                'profesor_id' => $profesor_id
            ]);
        }

        echo "<script>alert('✅ Asistencia del profesor guardada exitosamente.'); window.location.href='asistencia_profesores.php';</script>";
    } else {
        echo "<script>alert('⚠️ No seleccionaste asistencia.'); window.location.href='asistencia_profesores.php';</script>";
    }
} else {
    header('Location: asistencia_profesores.php');
}
?>
