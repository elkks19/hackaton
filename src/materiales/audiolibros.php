<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$audio_file = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_file'])) {
    $upload_dir = __DIR__ . '/uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $tmp_path = $_FILES['pdf_file']['tmp_name'];
    $pdf_name = uniqid('pdf_', true) . '.pdf';
    $pdf_path = $upload_dir . $pdf_name;

    if (move_uploaded_file($tmp_path, $pdf_path)) {
        $cmd = "python3 ../../api/app.py \"$pdf_path\" 2>&1";
        exec($cmd, $output, $status);

        if ($status === 0 && !empty($output[0])) {
            $full_path = trim($output[0]);
            if (file_exists($full_path)) {
                $audio_file = str_replace(__DIR__ . '/', '', $full_path);
            } else {
                $error_message = "⚠ Audio no generado.";
            }
        } else {
            $error_message = "⚠ Error: " . implode("<br>", $output);
        }
    } else {
        $error_message = "⚠ Fallo al subir el archivo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PDF a Audio</title>
</head>
<body>
    <h2>Sube un PDF para convertirlo a audio</h2>

    <?php if ($audio_file): ?>
        <p style="color: green;">✅ ¡Audio generado!</p>
        <audio controls>
            <source src="<?= htmlspecialchars($audio_file) ?>" type="audio/mpeg">
            Tu navegador no soporta audio.
        </audio>
        <br><a href="<?= htmlspecialchars($audio_file) ?>" download>⬇ Descargar audio</a>
    <?php elseif ($error_message): ?>
        <p style="color: red;"><?= $error_message ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <label>Selecciona un archivo PDF:</label><br>
        <input type="file" name="pdf_file" accept="application/pdf" required><br><br>
        <button type="submit">Convertir
