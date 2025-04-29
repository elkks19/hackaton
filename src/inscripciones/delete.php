<?php
require_once __DIR__ . '/../index.php';

use App\DB\Connection;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id) {
        $conn = Connection::get();
        $stmt = $conn->prepare('UPDATE inscripciones SET deleted_at = NOW() WHERE id = :id');
        $stmt->execute(['id' => $id]);

        $_SESSION['success'] = 'Inscripción eliminada correctamente.';
    }
}

header('Location: /src/inscripciones/');
exit;
