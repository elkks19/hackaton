<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Formas y Colores</title>
    <style>
        @import url('/public/baloo');
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Baloo 2', 'Comic Sans MS', cursive;
            text-align: center;
            background-color: #FFF8F0;
            cursor: pointer;
            overflow-x: hidden;
            background-image: radial-gradient(#FFA366 1px, transparent 1px);
            background-size: 30px 30px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        h1 {
            font-size: 4.5em;
            margin-bottom: 20px;
            color: #FF6B00;
            text-shadow: 
                3px 3px 0 #FFC299,
                -1px -1px 0 #CC5500,
                5px 5px 10px rgba(0,0,0,0.2);
            transform: rotate(-2deg);
            animation: bounce 4s infinite;
        }
        
        .slogan {
            font-size: 1.8em;
            color: #CC5500;
            margin-bottom: 60px;
            font-weight: 600;
        }
        
        .start-btn {
            font-size: 2em;
            padding: 25px 60px;
            border-radius: 60px;
            border: none;
            background-color: #FF6B00;
            color: white;
            font-family: 'Baloo 2', cursive;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 
                0 8px 0 #CC5500,
                0 15px 20px rgba(0,0,0,0.2);
            transition: all 0.2s;
            position: relative;
            z-index: 10;
        }
        
        .start-btn:hover {
            transform: translateY(-3px);
            box-shadow: 
                0 10px 0 #CC5500,
                0 15px 25px rgba(0,0,0,0.25);
        }
        
        .start-btn:active {
            transform: translateY(5px);
            box-shadow: 
                0 3px 0 #CC5500,
                0 5px 10px rgba(0,0,0,0.2);
        }
        
        .shape-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
            overflow: hidden;
        }
        
        .shape {
            position: absolute;
            opacity: 0.7;
        }
        
        .circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #FF6B00;
            left: 15%;
            top: 20%;
            animation: float 8s infinite ease-in-out;
        }
        
        .square {
            width: 80px;
            height: 80px;
            background-color: #FFA366;
            right: 18%;
            top: 15%;
            transform: rotate(15deg);
            animation: float 7s infinite ease-in-out 1s;
        }
        
        .triangle {
            width: 0;
            height: 0;
            border-left: 50px solid transparent;
            border-right: 50px solid transparent;
            border-bottom: 100px solid #CC5500;
            left: 22%;
            bottom: 15%;
            animation: float 9s infinite ease-in-out 0.5s;
        }
        
        .rectangle {
            width: 120px;
            height: 60px;
            background-color: #FFCC99;
            right: 25%;
            bottom: 20%;
            transform: rotate(-10deg);
            animation: float 10s infinite ease-in-out 1.5s;
        }
        
        .star {
            width: 0;
            height: 0;
            border-left: 25px solid transparent;
            border-right: 25px solid transparent;
            border-bottom: 50px solid #FF8533;
            position: absolute;
            left: 80%;
            top: 60%;
        }
        
        .star:after {
            content: "";
            width: 0;
            height: 0;
            border-left: 25px solid transparent;
            border-right: 25px solid transparent;
            border-top: 50px solid #FF8533;
            position: absolute;
            top: 15px;
            left: -25px;
        }
        
        /* Figuras grandes animadas en los bordes */
        .big-circle {
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background-color: rgba(255, 107, 0, 0.1);
            position: absolute;
            left: -200px;
            top: -200px;
            animation: pulse 8s infinite alternate;
        }
        
        .big-square {
            width: 350px;
            height: 350px;
            background-color: rgba(255, 163, 102, 0.1);
            position: absolute;
            right: -175px;
            bottom: -175px;
            transform: rotate(45deg);
            animation: pulse 7s infinite alternate-reverse;
        }

        /* Ilustraciones de niños */
        .children {
            position: absolute;
            width: 150px;
            height: 200px;
            background-size: contain;
            background-repeat: no-repeat;
            z-index: 5;
        }
        
        .child1 {
            bottom: 10px;
            left: 10%;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 150'%3E%3Cellipse cx='50' cy='30' rx='20' ry='22' fill='%23FFD6B0'/%3E%3Ccircle cx='42' cy='26' r='3' fill='%23333'/%3E%3Ccircle cx='58' cy='26' r='3' fill='%23333'/%3E%3Cpath d='M45 35 Q50 40 55 35' stroke='%23333' stroke-width='2' fill='none'/%3E%3Cpath d='M30 30 Q35 15 50 10 Q65 15 70 30' stroke='%23663300' stroke-width='4' fill='none'/%3E%3Cpath d='M35 55 L50 80 L65 55' fill='%23FF6B00'/%3E%3Crect x='40' y='80' width='20' height='25' fill='%23FFA366'/%3E%3Crect x='38' y='105' width='10' height='25' fill='%23CC5500'/%3E%3Crect x='52' y='105' width='10' height='25' fill='%23CC5500'/%3E%3Crect x='25' y='55' width='10' height='30' fill='%23FFA366'/%3E%3Crect x='65' y='55' width='10' height='30' fill='%23FFA366'/%3E%3C/svg%3E");
            animation: wave 3s infinite;
        }
        
        .child2 {
            bottom: 10px;
            right: 10%;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 150'%3E%3Cellipse cx='50' cy='30' rx='20' ry='22' fill='%23FFD6B0'/%3E%3Ccircle cx='42' cy='26' r='3' fill='%23333'/%3E%3Ccircle cx='58' cy='26' r='3' fill='%23333'/%3E%3Cpath d='M45 38 Q50 42 55 38' stroke='%23333' stroke-width='2' fill='none'/%3E%3Cpath d='M25 25 Q35 5 50 10 Q65 5 75 25' stroke='%23996633' stroke-width='4' fill='none'/%3E%3Cpath d='M35 55 L50 80 L65 55' fill='%23FF8533'/%3E%3Crect x='40' y='80' width='20' height='25' fill='%23CC5500'/%3E%3Crect x='38' y='105' width='10' height='25' fill='%23FFA366'/%3E%3Crect x='52' y='105' width='10' height='25' fill='%23FFA366'/%3E%3Crect x='25' y='55' width='10' height='30' fill='%23FF8533'/%3E%3Crect x='65' y='55' width='10' height='30' fill='%23FF8533'/%3E%3C/svg%3E");
            animation: bounce 4s infinite alternate;
        }
        
        /* Decoración adicional */
        .sun {
            position: absolute;
            top: 40px;
            right: 50px;
            width: 100px;
            height: 100px;
            background-color: #FFCC00;
            border-radius: 50%;
            box-shadow: 0 0 40px #FFCC00;
            animation: shine 5s infinite alternate;
        }
        
        .cloud {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50px;
            width: 200px;
            height: 60px;
            top: 80px;
            left: 80px;
        }
        
        .cloud:before {
            content: "";
            position: absolute;
            background-color: rgba(255, 255, 255, 0.8);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            top: -40px;
            left: 30px;
        }
        
        .cloud:after {
            content: "";
            position: absolute;
            background-color: rgba(255, 255, 255, 0.8);
            width: 100px;
            height: 100px;
            border-radius: 50%;
            top: -50px;
            right: 30px;
        }
        
        /* Pulsación inicial */
        .pulse-hint {
            position: absolute;
            bottom: 160px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 1.5em;
            color: #CC5500;
            opacity: 1;
            animation: pulse-text 2s infinite;
        }
        
        .hand-icon {
            width: 50px;
            height: 50px;
            display: inline-block;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23FF6B00'%3E%3Cpath d='M11.9 10.5c-1.6 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3zm0-4c-.6 0-1 .4-1 1s.4 1 1 1 1-.4 1-1-.4-1-1-1zm7 4.5v3.6l-1.8 5.4H6.2l-2-6H6l1.5 4h6.9l1-3h-3.3L11 10.8c-.3-.3-.5-.6-.5-1V6.5c0-.8.7-1.5 1.5-1.5s1.5.7 1.5 1.5V9h1.5V6.5c0-.8.7-1.5 1.5-1.5s1.5.7 1.5 1.5V9h.9c.5 0 1 .4 1 1z'/%3E%3C/svg%3E");
            background-size: contain;
            vertical-align: middle;
            margin-left: 10px;
            animation: tap 2s infinite;
        }
        
        /* Animaciones */
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0) rotate(-2deg); }
            50% { transform: translateY(-15px) rotate(0deg); }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.1; }
            50% { transform: scale(1.1); opacity: 0.2; }
            100% { transform: scale(1); opacity: 0.1; }
        }
        
        @keyframes shine {
            0% { box-shadow: 0 0 40px #FFCC00; }
            50% { box-shadow: 0 0 60px #FFCC00; }
            100% { box-shadow: 0 0 40px #FFCC00; }
        }
        
        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(5deg); }
            75% { transform: rotate(-5deg); }
        }
        
        @keyframes pulse-text {
            0%, 100% { opacity: 0.5; transform: translateX(-50%) scale(1); }
            50% { opacity: 1; transform: translateX(-50%) scale(1.1); }
        }
        
        @keyframes tap {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(10px); }
        }
        
        /* Responsivo */
        @media (max-width: 768px) {
            h1 {
                font-size: 3em;
            }
            
            .slogan {
                font-size: 1.5em;
            }
            
            .start-btn {
                font-size: 1.5em;
                padding: 20px 40px;
            }
            
            .shape {
                transform: scale(0.7);
            }
            
            .big-circle, .big-square {
                transform: scale(0.7);
            }
            
            .children {
                width: 120px;
                height: 160px;
            }
        }
        
        @media (max-width: 480px) {
            h1 {
                font-size: 2.5em;
            }
            
            .cloud, .sun {
                display: none;
            }
        }
    </style>
</head>
<body onclick="playAudio()">
    <div class="container">
        <!-- Formas decorativas de fondo -->
        <div class="shape-container">
            <div class="big-circle"></div>
            <div class="big-square"></div>
            <div class="shape circle"></div>
            <div class="shape square"></div>
            <div class="shape triangle"></div>
            <div class="shape rectangle"></div>
            <div class="shape star"></div>
        </div>
        
        <!-- Decoración adicional -->
        <div class="sun"></div>
        <div class="cloud"></div>
        
        <!-- Personajes -->
        <div class="children child1"></div>
        <div class="children child2"></div>
        
        <h1>¡Formas y Colores!</h1>
        <p class="slogan">Un juego divertido para aprender</p>
        
        <!-- Audio de bienvenida -->
        <audio id="bienvenidaAudio">
            <source src="audio/instrucciones.mp3" type="audio/mpeg">
            Tu navegador no soporta audio.
        </audio>
        
        <!-- Indicador para tocar -->
        <div class="pulse-hint">
            Toca la pantalla para escuchar
            <span class="hand-icon"></span>
        </div>
        
        <form action="juego.php" method="get">
            <button type="submit" class="start-btn">¡Comenzar!</button>
        </form>
    </div>
    
    <script>
        let reproducido = false;
        
        function playAudio() {
            if (!reproducido) {
                document.getElementById('bienvenidaAudio').play();
                reproducido = true;
                
                // Ocultar la indicación después de reproducir
                document.querySelector('.pulse-hint').style.display = 'none';
            }
        }
        
        // Animación automática para captar la atención
        setTimeout(() => {
            if (!reproducido) {
                const hintElement = document.querySelector('.pulse-hint');
                hintElement.style.animation = 'pulse-text 1s infinite';
            }
        }, 3000);
    </script>
</body>
</html>
