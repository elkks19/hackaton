<?php
$audio_file = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_file'])) {
    $upload_dir = __DIR__ . '/uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $pdf_tmp = $_FILES['pdf_file']['tmp_name'];
    $pdf_name = uniqid('pdf_', true) . '.pdf';
    $pdf_path = $upload_dir . $pdf_name;

    if (move_uploaded_file($pdf_tmp, $pdf_path)) {
        $base = pathinfo($pdf_name, PATHINFO_FILENAME);
        $txt_path = $upload_dir . $base . '.txt';
        $mp3_path = $upload_dir . $base . '.mp3';

        $cmd = escapeshellcmd("python ../../api/app.py \"$pdf_path\" \"$txt_path\" \"$mp3_path\"");

        exec($cmd, $output, $status);

        if ($status === 0 && file_exists($mp3_path)) {
            $audio_file = 'uploads/' . basename($mp3_path);
        } else {
            $error_message = "❌ Error al procesar el PDF.";
        }
    } else {
        $error_message = "❌ No se pudo subir el archivo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PDF a Audio</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #eef1f5;
            padding: 2em;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 2em;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 1em;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 1em;
        }
        input[type="file"] {
            padding: 0.5em;
        }
        input[type="submit"] {
            background: #007bff;
            color: white;
            border: none;
            padding: 0.75em;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        input[type="submit"]:hover {
            background: #0056b3;
        }
        .audio-preview {
            margin-top: 2em;
            text-align: center;
        }
        .error, .success {
            margin-top: 1em;
            padding: 1em;
            border-radius: 5px;
        }
        .error {
            background-color: #f8d7da;
            color: #842029;
        }
        .success {
            background-color: #d1e7dd;
            color: #0f5132;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎧 Convertir PDF a Audio</h1>
        <form action="audiolibros.php" method="post" enctype="multipart/form-data">
            <input type="file" name="pdf_file" accept="application/pdf" required>
            <input type="submit" value="Convertir a Audio">
        </form>

        <?php if ($error_message): ?>
            <div class="error"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>

        <?php if ($audio_file): ?>
            <div class="success">✅ Audio generado correctamente</div>
            <div class="audio-preview">
                <audio controls>
                    <source src="<?= htmlspecialchars($audio_file) ?>" type="audio/mpeg">
                    Tu navegador no soporta audio.
                </audio>
                <p><a href="<?= htmlspecialchars($audio_file) ?>" download>⬇ Descargar audio</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
