<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $fecha = $_POST['fecha'] ?? null;
    $tipo_discapacidad = $_POST['tipo_discapacidad'] ?? null;
    $documentos = $_FILES['documentos'] ?? null;

    if (!$id || !$fecha || !$tipo_discapacidad) {
        die('Faltan datos requeridos.');
    }

    $conn = Connection::get();

    // Actualizar inscripción
    $stmt = $conn->prepare('
        UPDATE inscripciones
        SET fecha = :fecha, tipo_discapacidad = :tipo_discapacidad, updated_at = NOW()
        WHERE id = :id AND deleted_at IS NULL
    ');
    $stmt->execute([
        'fecha' => $fecha,
        'tipo_discapacidad' => $tipo_discapacidad,
        'id' => $id,
    ]);

    // Subir nuevos documentos (si hay)
    $uploadDir = __DIR__ . '/uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0775, true);
    }

    if ($documentos && isset($documentos['tmp_name'])) {
        foreach ($documentos['tmp_name'] as $index => $tmpPath) {
            if ($tmpPath === '' || $documentos['error'][$index] !== UPLOAD_ERR_OK) {
                continue;
            }

            $originalName = basename($documentos['name'][$index]);
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $newName = uniqid('doc_') . '.' . $extension;
            $destination = $uploadDir . $newName;

            move_uploaded_file($tmpPath, $destination);

            $url_documento = '/src/inscripciones/uploads/' . $newName;

            $stmt = $conn->prepare('
                INSERT INTO documentos (inscripcion_id, url_documento)
                VALUES (:inscripcion_id, :url_documento)
            ');
            $stmt->execute([
                'inscripcion_id' => $id,
                'url_documento' => $url_documento,
            ]);
        }
    }

    $_SESSION['success'] = 'Inscripción actualizada correctamente.';
    header('Location: /src/inscripciones/');
    exit;
}

http_response_code(405);
echo "Método no permitido";
