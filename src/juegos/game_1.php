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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signo Generador - Braille</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --accent-color: #f39c12;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
            --success-color: #2ecc71;
            --text-color: #34495e;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        h1 {
            color: var(--dark-color);
            margin: 0;
            font-size: 2.2em;
        }
        
        .subtitle {
            color: #7f8c8d;
            font-weight: 300;
            margin-top: 5px;
        }
        
        .contenedor-botones {
            display: grid;
            grid-template-columns: repeat(2, 120px);
            grid-template-rows: repeat(3, 120px);
            gap: 25px;
            justify-content: center;
            margin-bottom: 40px;
        }
        
        button.braille-btn {
            font-size: 2.2em;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            outline: none;
            background-color: var(--light-color);
            color: var(--dark-color);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        button.braille-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
        
        button.braille-btn:active {
            transform: translateY(1px);
        }
        
        button.braille-btn.active {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.4);
        }
        
        .braille-btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            transition: transform 0.5s;
        }
        
        .braille-btn:active::after {
            transform: translate(-50%, -50%) scale(20);
            opacity: 0;
        }
        
        .resultado-container {
            background-color: var(--light-color);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-top: 20px;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
        }
        
        #resultado {
            margin: 0;
            font-size: 28px;
            color: var(--dark-color);
            font-weight: 600;
        }
        
        .letra-destacada {
            font-size: 48px;
            color: var(--primary-color);
            display: block;
            margin-top: 10px;
            min-height: 60px;
        }
        
        .instrucciones {
            margin-top: 30px;
            padding: 15px 20px;
            background-color: rgba(52, 152, 219, 0.1);
            border-left: 4px solid var(--primary-color);
            border-radius: 4px;
        }
        
        .instrucciones h3 {
            margin-top: 0;
            color: var(--primary-color);
        }
        
        .instrucciones p {
            margin-bottom: 0;
            line-height: 1.6;
        }
        
        footer {
            margin-top: 40px;
            text-align: center;
            color: #95a5a6;
            font-size: 0.9em;
        }
        
        .timer-bar {
            height: 5px;
            background-color: #e0e0e0;
            margin-top: 20px;
            border-radius: 5px;
            overflow: hidden;
            position: relative;
        }
        
        .timer-progress {
            width: 100%;
            height: 100%;
            background-color: var(--primary-color);
            transform-origin: left;
            transition: transform 5s linear;
        }
        
        .timer-active {
            transform: scaleX(0);
        }
        
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                padding: 15px;
            }
            
            .contenedor-botones {
                grid-template-columns: repeat(2, 100px);
                grid-template-rows: repeat(3, 100px);
                gap: 15px;
            }
            
            button.braille-btn {
                width: 100px;
                height: 100px;
                font-size: 1.8em;
            }
            
            h1 {
                font-size: 1.8em;
            }
            
            #resultado {
                font-size: 24px;
            }
            
            .letra-destacada {
                font-size: 36px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>Signo Generador en Braille</h1>
        <p class="subtitle">Aprende alfabeto Braille de forma interactiva</p>
    </header>

    <div class="contenedor-botones">
        <?php
        $ordenTabulacion = [1, 4, 2, 5, 3, 6];

        foreach ($ordenTabulacion as $tabindex => $numero) {
            echo '<button 
                    id="btn' . $numero . '" 
                    class="braille-btn" 
                    tabindex="' . ($tabindex + 1) . '" 
                    onfocus="reproducirAudioNumero(' . $numero . ')" 
                    onclick="activarBotonYConfirmar(' . $numero . ')" 
                    aria-label="Número ' . $numero . '">'
                    . $numero .
                '</button>';
        }
        ?>
    </div>

    <!-- Resultado de la letra -->
    <div class="resultado-container">
        <p id="resultado">Letra detectada:</p>
        <div class="letra-destacada" id="letra-braille"></div>
        <div class="timer-bar">
            <div class="timer-progress" id="timer-progress"></div>
        </div>
    </div>

    <div class="instrucciones">
        <h3><i class="fas fa-info-circle"></i> Cómo usar</h3>
        <p>Activa los puntos presionando los botones para formar una letra en Braille. El sistema detectará automáticamente la letra correspondiente. Después de 5 segundos de inactividad, el sistema se reiniciará.</p>
    </div>

    <footer>
        <p>Aplicación educativa de Braille &copy; 2025</p>
    </footer>
</div>

<!-- Audios -->
<audio id="audioNumero"></audio>
<audio id="audioConfirmacion" src="audios/campanita.mp3"></audio>

<script>
// Diccionario Braille
const brailleAlphabet = {
    '100000': 'A',
    '110000': 'B',
    '100100': 'C',
    '100110': 'D',
    '100010': 'E',
    '110100': 'F',
    '110110': 'G',
    '110010': 'H',
    '010100': 'I',
    '010110': 'J',
    '101000': 'K',
    '111000': 'L',
    '101100': 'M',
    '101110': 'N',
    '101010': 'O',
    '111100': 'P',
    '111110': 'Q',
    '111010': 'R',
    '011100': 'S',
    '011110': 'T',
    '101001': 'U',
    '111001': 'V',
    '010111': 'W',
    '101101': 'X',
    '101111': 'Y',
    '101011': 'Z'
};

// Timer de inactividad
let inactivityTimer;
let timerAnimation;

// Reproducir el audio del número (cuando te enfocas sobre el botón)
function reproducirAudioNumero(numero) {
    const audio = document.getElementById('audioNumero');
    audio.src = 'audios/' + numero + '.mp3'; // Audios de 1.mp3, 2.mp3, etc.
    audio.play().catch(err => {
        console.warn('No se pudo reproducir el audio del número:', err);
    });

    resetInactivityTimer();
}

// Reproducir audio de confirmación (campanita) al presionar
function reproducirAudioConfirmacion() {
    const audioConfirmacion = document.getElementById('audioConfirmacion');
    audioConfirmacion.currentTime = 0;
    audioConfirmacion.play().catch(err => {
        console.warn('No se pudo reproducir el audio de confirmación:', err);
    });
}

// Activar o desactivar botón
function activarBoton(numero) {
    const boton = document.getElementById('btn' + numero);
    boton.classList.toggle('active');
}

// Combinar activar, sonar campanita y detectar letra
function activarBotonYConfirmar(numero) {
    activarBoton(numero);
    reproducirAudioConfirmacion();
    detectarLetra();
    resetInactivityTimer();
}

// Detectar letra según botones activos
function detectarLetra() {
    const botones = [
        document.getElementById('btn1').classList.contains('active') ? '1' : '0',
        document.getElementById('btn2').classList.contains('active') ? '1' : '0',
        document.getElementById('btn3').classList.contains('active') ? '1' : '0',
        document.getElementById('btn4').classList.contains('active') ? '1' : '0',
        document.getElementById('btn5').classList.contains('active') ? '1' : '0',
        document.getElementById('btn6').classList.contains('active') ? '1' : '0'
    ];

    const patron = botones.join('');
    const letra = brailleAlphabet[patron] || '';
    
    document.getElementById('resultado').textContent = letra ? 'Letra detectada:' : 'Configura los puntos Braille';
    document.getElementById('letra-braille').textContent = letra;
}

// Reiniciar botones y letra después de 5 segundos
function reiniciarSistema() {
    const botones = document.querySelectorAll('.braille-btn');
    botones.forEach(boton => boton.classList.remove('active'));
    document.getElementById('resultado').textContent = 'Configura los puntos Braille';
    document.getElementById('letra-braille').textContent = '';
    resetTimerAnimation();
}

// Manejar la animación del temporizador
function startTimerAnimation() {
    const timerBar = document.getElementById('timer-progress');
    timerBar.classList.remove('timer-active');
    void timerBar.offsetWidth; // Forzar reflow
    timerBar.classList.add('timer-active');
}

function resetTimerAnimation() {
    const timerBar = document.getElementById('timer-progress');
    timerBar.classList.remove('timer-active');
}

// Reiniciar temporizador de inactividad
function resetInactivityTimer() {
    clearTimeout(inactivityTimer);
    resetTimerAnimation();
    
    // Pequeño retraso para asegurar que la animación se reinicia correctamente
    setTimeout(() => {
        startTimerAnimation();
    }, 50);
    
    inactivityTimer = setTimeout(() => {
        reiniciarSistema();
    }, 5000); // 5 segundos
}

// Iniciar al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    detectarLetra(); // Detectar estado inicial
});

// Navegar con flechas
document.addEventListener('keydown', function(event) {
    const botones = Array.from(document.querySelectorAll('.braille-btn'));
    const currentIndex = botones.findIndex(btn => btn === document.activeElement);
    if (currentIndex === -1) return;

    const columnas = 2;
    let newIndex = currentIndex;

    switch (event.key) {
        case 'ArrowRight':
            if ((currentIndex + 1) % columnas !== 0) newIndex = currentIndex + 1;
            break;
        case 'ArrowLeft':
            if (currentIndex % columnas !== 0) newIndex = currentIndex - 1;
            break;
        case 'ArrowDown':
            if (currentIndex + columnas < botones.length) newIndex = currentIndex + columnas;
            break;
        case 'ArrowUp':
            if (currentIndex - columnas >= 0) newIndex = currentIndex - columnas;
            break;
        case ' ':
        case 'Enter':
            // Activar el botón con espacio o enter
            const botonActual = botones[currentIndex];
            const numeroBoton = botonActual.id.replace('btn', '');
            activarBotonYConfirmar(numeroBoton);
            event.preventDefault();
            return;
        default:
            return;
    }

    if (newIndex !== currentIndex) {
        botones[newIndex]?.focus();
        event.preventDefault();
    }
});
</script>

</body>
</html>
