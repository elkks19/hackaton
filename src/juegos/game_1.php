<?php
$numeros = [
    1 => 'UNO',
    2 => 'DOS',
    3 => 'TRES',
    4 => 'CUATRO',
    5 => 'CINCO',
    6 => 'SEIS'
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Signo Generador - Braille</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 30px;
        }
        .contenedor-botones {
            display: grid;
            grid-template-columns: repeat(2, 100px);
            grid-template-rows: repeat(3, 100px);
            gap: 20px;
            justify-content: center;
            margin-bottom: 50px;
        }
        button.braille-btn {
            font-size: 2em;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 2px solid #333;
            cursor: pointer;
            outline: none;
            background-color: white;
            transition: background-color 0.3s;
        }
        button.braille-btn.active {
            background-color: black;
            color: white;
        }
        h1 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<h1>Signo Generador en Braille</h1>

<div class="contenedor-botones">
    <?php
    // Definimos el orden específico de tabulador
    $ordenTabulacion = [1, 4, 2, 5, 3, 6];

    foreach ($ordenTabulacion as $tabindex => $numero) {
        echo '<button 
                id="btn' . $numero . '" 
                class="braille-btn" 
                tabindex="' . ($tabindex + 1) . '" 
                onfocus="playSound(' . $numero . ')" 
                onmouseover="playSound(' . $numero . ')" 
                onclick="activarBoton(' . $numero . ')" 
                aria-label="Número ' . $numero . '">'
                . $numero .
             '</button>';
    }
    ?>
</div>

<audio id="audioPlayer"></audio>

<script>
// Reproducir sonido
function playSound(numero) {
    var audio = document.getElementById('audioPlayer');
    audio.src = 'audios/' + numero + '.mp3';
    audio.play();
}

// Activar fondo negro al presionar
function activarBoton(numero) {
    var botones = document.querySelectorAll('.braille-btn');
    botones.forEach(function(boton) {
        boton.classList.remove('active');
    });
    document.getElementById('btn' + numero).classList.add('active');
}

// Moverse con las flechas
document.addEventListener('keydown', function(event) {
    const botones = Array.from(document.querySelectorAll('.braille-btn'));
    const currentIndex = botones.findIndex(btn => btn === document.activeElement);
    
    if (currentIndex === -1) return; // Si no estamos en un botón, salir

    const columnas = 2; // Porque tu grid es de 2 columnas

    let newIndex = currentIndex;

    switch (event.key) {
        case 'ArrowRight':
            if ((currentIndex + 1) % columnas !== 0) { // No pasar de la derecha
                newIndex = currentIndex + 1;
            }
            event.preventDefault();
            break;
        case 'ArrowLeft':
            if (currentIndex % columnas !== 0) { // No pasar de la izquierda
                newIndex = currentIndex - 1;
            }
            event.preventDefault();
            break;
        case 'ArrowDown':
            if (currentIndex + columnas < botones.length) { // Si existe botón abajo
                newIndex = currentIndex + columnas;
            }
            event.preventDefault();
            break;
        case 'ArrowUp':
            if (currentIndex - columnas >= 0) { // Si existe botón arriba
                newIndex = currentIndex - columnas;
            }
            event.preventDefault();
            break;
    }

    if (newIndex !== currentIndex) {
        botones[newIndex]?.focus();
    }
});
</script>

</body>
</html>