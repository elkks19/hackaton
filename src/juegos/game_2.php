<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simón Dice Sonoro</title>
    <style>
        :root {
            --primary-bg: linear-gradient(135deg, #0f0f23 0%, #1a1a3a 100%);
            --card-bg: rgba(255, 255, 255, 0.03);
            --text-primary: #ffffff;
            --text-secondary: #b0b8c8;
            --border: rgba(255, 255, 255, 0.1);
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            --glow: 0 0 20px rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--primary-bg);
            color: var(--text-primary);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-x: hidden;
        }

        .container {
            max-width: 600px;
            width: 100%;
            text-align: center;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 3s ease-in-out infinite;
            text-shadow: 0 0 30px rgba(255, 255, 255, 0.1);
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .controls {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .control-btn {
            padding: 12px 24px;
            border: none;
            border-radius: 50px;
            background: var(--card-bg);
            color: var(--text-primary);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .control-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .control-btn:hover::before {
            left: 100%;
        }

        .control-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .control-btn:active {
            transform: translateY(0);
        }

        .mensaje {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            font-size: 1.2rem;
            font-weight: 600;
            box-shadow: var(--shadow);
            min-height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .mensaje.success {
            border-color: #27ae60;
            box-shadow: 0 0 30px rgba(39, 174, 96, 0.3);
        }

        .mensaje.error {
            border-color: #e74c3c;
            box-shadow: 0 0 30px rgba(231, 76, 60, 0.3);
        }

        .game-board {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            max-width: 400px;
            margin: 0 auto 2rem;
            perspective: 1000px;
        }

        .boton {
            width: 140px;
            height: 140px;
            border: none;
            border-radius: 20px;
            font-size: 3rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 3px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .boton::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .boton:hover::before {
            opacity: 1;
        }

        .boton:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        }

        .boton:active {
            transform: translateY(-4px) scale(1.02);
        }

        .boton.active {
            transform: scale(0.95);
            filter: brightness(1.5);
            box-shadow: inset 0 0 30px rgba(255, 255, 255, 0.3);
        }

        .rojo { 
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
        }
        .rojo:hover {
            background: linear-gradient(135deg, #ff6b6b, #e74c3c);
            box-shadow: 0 20px 50px rgba(231, 76, 60, 0.4);
        }

        .verde { 
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
        }
        .verde:hover {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            box-shadow: 0 20px 50px rgba(39, 174, 96, 0.4);
        }

        .azul { 
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }
        .azul:hover {
            background: linear-gradient(135deg, #5dade2, #3498db);
            box-shadow: 0 20px 50px rgba(52, 152, 219, 0.4);
        }

        .amarillo { 
            background: linear-gradient(135deg, #f1c40f, #f39c12);
            color: #2c3e50;
        }
        .amarillo:hover {
            background: linear-gradient(135deg, #f7dc6f, #f1c40f);
            box-shadow: 0 20px 50px rgba(241, 196, 15, 0.4);
        }

        .keyboard-guide {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 1.5rem;
            margin-top: 1rem;
            box-shadow: var(--shadow);
        }

        .keyboard-guide h3 {
            margin-bottom: 1rem;
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        .key-map {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .key-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .key-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
        }

        .round-indicator {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            border-radius: 50px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            box-shadow: var(--shadow);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .round-indicator.visible {
            opacity: 1;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 10px;
            }
            
            .game-board {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
                max-width: 300px;
            }
            
            .boton {
                width: 100px;
                height: 100px;
                font-size: 2rem;
            }
            
            .controls {
                flex-direction: column;
                align-items: center;
            }
            
            .control-btn {
                width: 200px;
            }
        }

        @media (max-width: 480px) {
            .game-board {
                gap: 0.8rem;
                max-width: 250px;
            }
            
            .boton {
                width: 80px;
                height: 80px;
                font-size: 1.5rem;
            }
        }

        /* Animaciones de pulsación */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); filter: brightness(1.3); }
            100% { transform: scale(1); }
        }

        .boton.pulsing {
            animation: pulse 0.6s ease-in-out;
        }

        /* Efectos de partículas para feedback */
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: white;
            border-radius: 50%;
            pointer-events: none;
            animation: particleFly 1s ease-out forwards;
        }

        @keyframes particleFly {
            0% {
                opacity: 1;
                transform: translate(0, 0) scale(1);
            }
            100% {
                opacity: 0;
                transform: translate(var(--random-x, 50px), var(--random-y, -50px)) scale(0);
            }
        }
    </style>
</head>
<body>
    <div class="round-indicator" id="roundIndicator">Ronda 1</div>
    
    <div class="container">
        <h1 class="title">🎵 Simón Dice</h1>
        
        <div class="controls">
            <button class="control-btn" id="iniciarBtn">🎮 Iniciar Juego</button>
            <button class="control-btn" id="instruccionesBtn">📢 Instrucciones</button>
        </div>

        <div class="mensaje" id="mensaje">
            Presiona "Iniciar Juego" para comenzar tu aventura musical
        </div>

        <div class="game-board" id="panel">
            <button class="boton rojo" data-color="rojo">⬆️</button>
            <button class="boton verde" data-color="verde">⬇️</button>
            <button class="boton azul" data-color="celeste">⬅️</button>
            <button class="boton amarillo" data-color="amarillo">➡️</button>
        </div>

        <div class="keyboard-guide">
            <h3>🎹 Controles del Teclado</h3>
            <div class="key-map">
                <div class="key-item">⬆️ <span>Rojo</span></div>
                <div class="key-item">⬇️ <span>Verde</span></div>
                <div class="key-item">⬅️ <span>Celeste</span></div>
                <div class="key-item">➡️ <span>Amarillo</span></div>
            </div>
        </div>
    </div>

    <script>
        const sonidos = {
            rojo: new Audio("sonidos/rojo.mp3"),
            verde: new Audio("sonidos/verde.mp3"),
            celeste: new Audio("sonidos/celeste.mp3"),
            amarillo: new Audio("sonidos/amarillo.mp3"),
            correcto: new Audio("sonidos/correcto.mp3"),
            error: new Audio("sonidos/error.mp3"),
            instrucciones: new Audio("sonidos/instrucciones.mp3")
        };

        const botones = document.querySelectorAll('.boton');
        const mensaje = document.getElementById("mensaje");
        const roundIndicator = document.getElementById("roundIndicator");
        let secuencia = [];
        let entradaUsuario = [];
        let ronda = 0;
        let esperandoInput = false;

        function reproducirSonido(color) {
            if (sonidos[color]) {
                sonidos[color].currentTime = 0;
                sonidos[color].play();
            }
        }

        function createParticles(element) {
            const rect = element.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;
            
            for (let i = 0; i < 6; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = centerX + 'px';
                particle.style.top = centerY + 'px';
                particle.style.setProperty('--random-x', (Math.random() - 0.5) * 100 + 'px');
                particle.style.setProperty('--random-y', -Math.random() * 100 + 'px');
                document.body.appendChild(particle);
                
                setTimeout(() => particle.remove(), 1000);
            }
        }

        function actualizarMensaje(texto, tipo = '') {
            mensaje.textContent = texto;
            mensaje.className = `mensaje ${tipo}`;
        }

        function iniciarJuego() {
            secuencia = [];
            entradaUsuario = [];
            ronda = 0;
            roundIndicator.classList.add('visible');
            actualizarMensaje("¡Preparándote para la aventura musical! 🎵");
            setTimeout(siguienteRonda, 1000);
        }

        function siguienteRonda() {
            esperandoInput = false;
            entradaUsuario = [];
            ronda++;
            roundIndicator.textContent = `Ronda ${ronda}`;
            actualizarMensaje(`🎯 Ronda ${ronda} - Observa y memoriza`);

            const colores = ['rojo', 'verde', 'celeste', 'amarillo'];
            const colorAleatorio = colores[Math.floor(Math.random() * colores.length)];
            secuencia.push(colorAleatorio);

            const nuevoColor = secuencia[secuencia.length - 1];
            const boton = document.querySelector(`[data-color="${nuevoColor}"]`);

            setTimeout(() => {
                boton.classList.add('pulsing', 'active');
                reproducirSonido(nuevoColor);
                createParticles(boton);
                
                setTimeout(() => {
                    boton.classList.remove('pulsing', 'active');
                    esperandoInput = true;
                    actualizarMensaje(`🎮 Tu turno - Repite la secuencia (${ronda} ${ronda === 1 ? 'color' : 'colores'})`);
                }, 600);
            }, 800);
        }

        function manejarInput(color) {
            if (!esperandoInput) return;

            const boton = document.querySelector(`[data-color="${color}"]`);
            boton.classList.add('active');
            reproducirSonido(color);
            createParticles(boton);
            
            setTimeout(() => boton.classList.remove('active'), 200);

            entradaUsuario.push(color);

            const index = entradaUsuario.length - 1;
            if (entradaUsuario[index] !== secuencia[index]) {
                sonidos.error.play();
                actualizarMensaje(`❌ ¡Ups! Secuencia incorrecta. Has llegado a la ronda ${ronda}`, 'error');
                esperandoInput = false;
                roundIndicator.classList.remove('visible');
                return;
            }

            if (entradaUsuario.length === secuencia.length) {
                esperandoInput = false;
                sonidos.correcto.play();
                actualizarMensaje(`✅ ¡Excelente! Preparándote para el siguiente desafío...`, 'success');
                setTimeout(siguienteRonda, 1500);
            }
        }

        // Event listeners para botones
        botones.forEach(boton => {
            boton.addEventListener('click', () => {
                const color = boton.getAttribute('data-color');
                manejarInput(color);
            });
        });

        document.getElementById('iniciarBtn').addEventListener('click', iniciarJuego);

        document.getElementById('instruccionesBtn').addEventListener('click', () => {
            reproducirSonido('instrucciones');
            actualizarMensaje('🎧 Escucha las instrucciones y prepárate para el desafío');
        });

        // Event listener para teclado
        document.addEventListener('keydown', (event) => {
            if (!esperandoInput) return;

            let color = null;
            switch (event.key) {
                case 'ArrowUp': color = 'rojo'; break;
                case 'ArrowDown': color = 'verde'; break;
                case 'ArrowLeft': color = 'celeste'; break;
                case 'ArrowRight': color = 'amarillo'; break;
            }

            if (color) {
                manejarInput(color);
            }
        });

        // Prevenir scroll con teclas de flecha
        document.addEventListener('keydown', (e) => {
            if(['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight'].includes(e.key)) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>