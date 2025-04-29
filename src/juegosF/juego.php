<?php
$formas = ['circulo', 'cuadrado', 'triangulo'];
$colores = ['amarillo', 'rojo', 'azul'];

$forma_correcta = $formas[array_rand($formas)];
$color_correcto = $colores[array_rand($colores)];

$respuesta_correcta = $forma_correcta . '_' . $color_correcto;

$mensaje = '';
$estado = '';
$audio_resultado = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $respuesta_usuario = $_POST['respuesta'];
    if ($respuesta_usuario === $_POST['correcta']) {
        $mensaje = '¡Muy bien!';
        $estado = 'correcto';
        $audio_resultado = 'audio/muy_bien.mp3';
    } else {
        $mensaje = '¡Inténtalo otra vez!';
        $estado = 'incorrecto';
        $audio_resultado = 'audio/intenta.mp3';
    }
}

// Mapeo de nombres de colores en español para las instrucciones
$nombres_colores = [
    'amarillo' => 'amarillo',
    'rojo' => 'rojo',
    'azul' => 'azul'
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego - Formas y Colores</title>
    <style>
        body {
            font-family: 'Comic Sans MS', 'Arial Rounded MT Bold', sans-serif;
            text-align: center;
            background-color: <?= $estado === 'correcto' ? '#d4f7d4' : ($estado === 'incorrecto' ? '#f7d4d4' : '#fff8f0'); ?>;
            padding: 20px;
            transition: background-color 0.5s;
        }
        h1 {
            font-size: 3em;
            color: #FF6B00;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }
        .instruccion {
            font-size: 2.5em;
            margin: 30px 0;
            color: #333;
            background-color: rgba(255, 255, 255, 0.7);
            padding: 15px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        form {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .boton-forma {
            width: 250px;
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            background-color: transparent;
            position: relative;
            transition: transform 0.2s;
            border-radius: 15px;
        }
        .boton-forma:hover {
            transform: scale(1.05);
        }
        .boton-forma:active {
            transform: scale(0.95);
        }

        .figura {
            width: 200px;
            height: 200px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            border: 5px solid #333;
        }

        /* Formas con alto contraste y tamaño extra grande */
        .circulo {
            border-radius: 50%;
        }
        .cuadrado {
            border-radius: 15px;
        }
        .triangulo {
            width: 0;
            height: 0;
            border-left: 100px solid transparent;
            border-right: 100px solid transparent;
            border-bottom: 200px solid; /* color se define con la clase de color */
            box-shadow: none;
            border-top: none;
            border-left: none;
            border-right: none;
        }

        /* Paleta de colores básicos */
        .amarillo { 
            background-color: #FFD700; 
        }
        .rojo { 
            background-color: #FF0000; 
        }
        .azul { 
            background-color: #0000FF; 
        }

        .triangulo.amarillo { 
            border-bottom-color: #FFD700; 
            background: none; 
        }
        .triangulo.rojo { 
            border-bottom-color: #FF0000; 
            background: none; 
        }
        .triangulo.azul { 
            border-bottom-color: #0000FF; 
            background: none; 
        }
        
        /* Estilo para el botón de jugar otra vez */
        .boton-jugar {
            padding: 20px 40px;
            font-size: 1.8em;
            background-color: #FF6B00;
            color: white;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
        }
        .boton-jugar:hover {
            background-color: #FF8533;
            transform: scale(1.05);
        }
        
        /* Mensaje de resultado */
        .mensaje-resultado {
            font-size: 3em;
            margin: 30px 0;
            padding: 20px;
            border-radius: 15px;
            background-color: <?= $estado === 'correcto' ? 'rgba(100, 200, 100, 0.3)' : 'rgba(200, 100, 100, 0.3)' ?>;
            animation: pulsar 1.5s infinite;
        }
        
        @keyframes pulsar {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        /* Líneas guía táctiles alrededor de las figuras */
        .boton-forma::after {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            border: 3px dashed #333;
            border-radius: 20px;
            pointer-events: none;
        }
    </style>
</head>
<body>

    <h1>Formas y Colores</h1>

    <?php if (!$mensaje): ?>
        <p class="instruccion">Toca el <strong><?= $forma_correcta ?> <?= $nombres_colores[$color_correcto] ?></strong></p>

        <!-- Audios -->
        <audio id="audio-forma">
            <source src="audio/<?= $forma_correcta ?>.mp3" type="audio/mpeg">
        </audio>
        <audio id="audio-color">
            <source src="audio/<?= $color_correcto ?>.mp3" type="audio/mpeg">
        </audio>

        <script>
            window.onload = () => {
                const audioForma = document.getElementById('audio-forma');
                const audioColor = document.getElementById('audio-color');

                audioForma.play();
                setTimeout(() => {
                    audioColor.play();
                }, 2000); // Mayor espera entre instrucciones para mejor comprensión
                
                // Agrega feedback táctil si está disponible
                const botones = document.querySelectorAll('.boton-forma');
                botones.forEach(boton => {
                    boton.addEventListener('click', () => {
                        if (navigator.vibrate) {
                            navigator.vibrate(100);
                        }
                    });
                });
            }
        </script>

        <form method="POST">
            <?php
            shuffle($formas);
            shuffle($colores);
            foreach ($formas as $forma) {
                foreach ($colores as $color) {
                    $valor = $forma . '_' . $color;
                    echo "<button class='boton-forma' type='submit' name='respuesta' value='$valor'>";
                    echo "<div class='figura $forma $color'></div>";
                    echo "</button>";
                }
            }
            ?>
            <input type="hidden" name="correcta" value="<?= $respuesta_correcta ?>">
        </form>
    <?php else: ?>
        <h2 class="mensaje-resultado"><?= $mensaje ?></h2>
        <audio autoplay>
            <source src="<?= $audio_resultado ?>" type="audio/mpeg">
        </audio>
        <br><br>
        <a href="juego.php"><button class="boton-jugar">Jugar otra vez</button></a>
    <?php endif; ?>

</body>
</html>