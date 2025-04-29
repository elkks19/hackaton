<?php
include 'conexion.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $nombre = $_POST['nombre']; 
    $descripcion = $_POST['descripcion']; 
    $fecha_inicio = $_POST['fecha_inicio']; 
    $fecha_fin = $_POST['fecha_fin']; 
    $profesor_id = $_POST['profesor_id']; 
    $estudiantes = isset($_POST['estudiantes']) ? $_POST['estudiantes'] : []; 

    try {
        
        $conn->beginTransaction();

   
        $sql = "INSERT INTO cursos (nombre, descripcion, fecha_inicio, fecha_fin, profesor_id, created_at) 
                VALUES (:nombre, :descripcion, :fecha_inicio, :fecha_fin, :profesor_id, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':fecha_inicio' => $fecha_inicio,
            ':fecha_fin' => $fecha_fin,
            ':profesor_id' => $profesor_id
        ]);
        
        // Obtener el ID del curso recién creado
        $curso_id = $conn->lastInsertId();

        // Si hay estudiantes seleccionados, insertarlos en la tabla estudiantes_curso
        if (!empty($estudiantes)) {
            $sqlEst = "INSERT INTO estudiantes_curso (curso_id, estudiante_id) VALUES (:curso_id, :estudiante_id)";
            $stmtEst = $conn->prepare($sqlEst);

            // Recorrer los estudiantes seleccionados y agregar su relación con el curso
            foreach ($estudiantes as $estudiante_id) {
                $stmtEst->execute([
                    ':curso_id' => $curso_id,
                    ':estudiante_id' => $estudiante_id
                ]);
            }
        }

        // Confirmar la transacción
        $conn->commit();

        // Redirigir a la página principal (index.php)
        header("Location: index.php");
        exit();
    } catch (Exception $e) {
        // En caso de error, revertir la transacción
        $conn->rollBack();
        echo "Error al guardar el curso: " . $e->getMessage();
    }
} else {

    header("Location: crear.php");
    exit();
}
