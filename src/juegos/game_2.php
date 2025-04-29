<?php
session_start();

// Opciones de letras
$opciones = ['a', 'b', 'c'];

// Si no existe una letra objetivo, la creamos
if (!isset($_SESSION['letraObjetivo']) || isset($_POST['nuevo'])) {
    $_SESSION['letraObjetivo'] = $opciones[array_rand($opciones)];
}

$letraObjetivo = $_SESSION['letraObjetivo'];
$mensaje = '';

// Respuestas asignadas
$asignaciones = [
    1 => 'a',
    2 => 'b',
    3 => 'c',
];

// Al recibir respuesta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['respuesta'])) {
    $respuesta = intval($_POST['respuesta']);
    if (isset($asignaciones[$respuesta]) && $asignaciones[$respuesta] === $letraObjetivo) {
        $mensaje = "✅ ¡Muy bien! Era la letra " . strtoupper($letraObjetivo);
        unset($_SESSION['letraObjetivo']); // Reiniciar para la siguiente
    } else {
        $mensaje = "❌ No era correcto. Intenta otra vez.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Juego de Opciones Braille</title>
    <style>
        body {
            background-color: #000;
            color: #FFFF00;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        .opciones {
            margin-top: 30px;
            font-size: 2rem;
        }
        input[type="text"] {
            font-size: 2rem;
            padding: 10px;
            width: 100px;
            text-align: center;
            margin-top: 20px;
            background: #00FF00;
            border: none;
            border-radius: 10px;
            color: #000;
            font-weight: bold;
        }
        button {
            margin-top: 20px;
            font-size: 1.5rem;
            padding: 10px 20px;
            background: #FFA500;
            border: none;
            border-radius: 10px;
            color: #000;
            font-weight: bold;
            cursor: pointer;
        }
        .mensaje {
            margin-top: 30px;
            font-size: 2rem;
        }
    </style>
</head>
<body>

    <h1>🎯 Adivina la letra (Opciones)</h1>
    <p>Escucha las opciones y presiona 1, 2 o 3:</p>

    <audio id="audio" autoplay>
        <source src="audios/<?php echo $letraObjetivo; ?>-opciones.mp3" type="audio/mpeg">
        Tu navegador no soporta audios.
    </audio>

    <form method="POST">
        <input type="text" name="respuesta" maxlength="1" autofocus autocomplete="off" placeholder="1, 2 o 3">
        <br>
        <button type="submit">Enviar</button>
        <button type="submit" name="nuevo" value="1">Otra letra</button>
    </form>

    <div class="mensaje"><?php echo $mensaje; ?></div>

</body>
</html>
