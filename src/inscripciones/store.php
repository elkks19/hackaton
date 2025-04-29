<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estudiante_id = $_POST['estudiante_id'] ?? null;
    $fecha = $_POST['fecha'] ?? date('Y-m-d');
    $tipo_discapacidad = $_POST['tipo_discapacidad'] ?? '';
    $documentos = $_FILES['documentos'] ?? null;

    if (!$estudiante_id || !$tipo_discapacidad || !$documentos) {
        die('Faltan datos');
    }

    $conn = Connection::get();

    // Insertar inscripción
    $stmt = $conn->prepare('
        INSERT INTO inscripciones (estudiante_id, fecha, tipo_discapacidad)
        VALUES (:estudiante_id, :fecha, :tipo_discapacidad)
    ');
    $stmt->execute([
        'estudiante_id' => $estudiante_id,
        'fecha' => $fecha,
        'tipo_discapacidad' => $tipo_discapacidad,
    ]);

    $inscripcion_id = $conn->lastInsertId();

    // Subir múltiples archivos
    $uploadDir = __DIR__ . '/uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0775, true);
    }

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
            'inscripcion_id' => $inscripcion_id,
            'url_documento' => $url_documento,
        ]);
    }

    $_SESSION['success'] = 'Inscripción creada con éxito.';
    header('Location: /src/inscripciones/create.php');
    exit;
}

http_response_code(405);
echo "Método no permitido";
