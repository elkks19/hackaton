<?php
include 'conexion.php';

// Verificar que llegaron datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clase_id = $_POST['clase_id'];
    $asistencias = $_POST['asistencia'] ?? [];

    if (!empty($asistencias)) {
        foreach ($asistencias as $estudiante_id) {
            // Verificar si ya existe asistencia para evitar duplicados
            $stmt = $pdo->prepare("
                SELECT * FROM asistencia_estudiantes 
                WHERE clase_id = :clase_id AND estudiante_id = :estudiante_id
            ");
            $stmt->execute([
                'clase_id' => $clase_id,
                'estudiante_id' => $estudiante_id
            ]);

            if ($stmt->rowCount() == 0) {
                // Insertar asistencia
                $insert = $pdo->prepare("
                    INSERT INTO asistencia_estudiantes (clase_id, estudiante_id) 
                    VALUES (:clase_id, :estudiante_id)
                ");
                $insert->execute([
                    'clase_id' => $clase_id,
                    'estudiante_id' => $estudiante_id
                ]);
            }
        }

        echo "<script>alert('✅ Asistencia guardada exitosamente.'); window.location.href='asistencia_estudiantes.php';</script>";
    } else {
        echo "<script>alert('⚠️ No seleccionaste ningún estudiante.'); window.location.href='asistencia_estudiantes.php';</script>";
    }
} else {
    header('Location: asistencia_estudiantes.php');
}
?>
