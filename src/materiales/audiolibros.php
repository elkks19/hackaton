<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_file'])) {
	$upload_dir = __DIR__ . '/uploads/';
	if (!file_exists($upload_dir)) {
		mkdir($upload_dir, 0777, true);
	}

	$pdf_path = $upload_dir . basename($_FILES['pdf_file']['name']);
	move_uploaded_file($_FILES['pdf_file']['tmp_name'], $pdf_path);

	// Ejecutar el script Python
	$command = "python3 ../../api/app.py " . escapeshellarg($pdf_path);
	exec($command . " 2>&1", $output, $return_var);
	echo "<pre>";
	print_r($output);
	echo "</pre>";

	$audio_file = trim(end($output));  // La última línea debería ser el .mp3

	if (file_exists($audio_file)) {
		echo "<h2>Vista previa del audio:</h2>";
		echo "<audio controls><source src='uploads/" . basename($audio_file) . "' type='audio/mpeg'></audio>";
	} else {
		echo "Error generando el audio.";
	}
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<title>Conversor PDF a Audio</title>
</head>

<body>
	<h1>Subir PDF para convertir a Audio</h1>
	<form method="POST" enctype="multipart/form-data">
		<input type="file" name="pdf_file" accept="application/pdf" required>
		<br><br>
		<button type="submit">Convertir</button>
	</form>
</body>

</html>
