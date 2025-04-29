<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Inicio</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #000000;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 20px;
            color: #ffffff;
            position: relative;
            overflow-x: hidden;
        }
        
        .container {
            max-width: 1200px;
            width: 100%;
            padding-top: 80px;
        }
        
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: #000000;
            padding: 15px 0;
            z-index: 100;
            border-bottom: 3px solid #ffffff;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .logo {
            font-size: 32px;
            font-weight: bold;
            color: #ffffff;
            letter-spacing: 1px;
        }
        
        .nav-links {
            display: flex;
            gap: 20px;
        }
        
        .nav-link {
            color: #ffffff;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 18px;
            transition: all 0.3s;
            position: relative;
            background-color: transparent;
            border: 2px solid #ffffff;
        }
        
        .nav-link:hover, .nav-link:focus {
            background: #ffffff;
            color: #000000;
            outline: 3px solid #ffff00;
        }
        
        .main-title {
            text-align: center;
            margin-bottom: 40px;
            font-size: 3.5rem;
            font-weight: bold;
            color: #ffffff;
            position: relative;
            padding-bottom: 15px;
        }
        
        .main-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 5px;
            background: #ffffff;
        }
        
        .dashboard {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            justify-content: center;
            margin-top: 60px;
        }
        
        .card {
            background: #000000;
            border-radius: 12px;
            overflow: hidden;
            width: 300px;
            height: 380px;
            transition: all 0.4s;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #ffffff;
            position: relative;
            border: 3px solid #ffffff;
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
        }
        
        .card:hover, .card:focus {
            transform: translateY(-10px);
            outline: 3px solid #ffff00;
        }
        
        .card-image {
            width: 100%;
            height: 180px;
            background-size: cover;
            background-position: center;
            position: relative;
            border-bottom: 3px solid #ffffff;
        }
        
        .games-image {
            background-image: url('/api/placeholder/300/180');
        }
        
        .books-image {
            background-image: url('/api/placeholder/300/180');
        }
        
        .card-image::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, transparent 50%, rgba(0, 0, 0, 0.7) 100%);
        }
        
        .card-content {
            padding: 20px;
            text-align: center;
            z-index: 2;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }
        
        .card-title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: #ffffff;
        }
        
        .card-desc {
            font-size: 16px;
            color: #ffffff;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        
        .card-button {
            background: #000000;
            color: #ffffff;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid #ffffff;
        }
        
        .card-button:hover, .card-button:focus {
            background: #ffffff;
            color: #000000;
            outline: 3px solid #ffff00;
        }
        
        .footer {
            width: 100%;
            text-align: center;
            padding: 30px 0;
            margin-top: 80px;
            font-size: 16px;
            color: #ffffff;
            border-top: 2px solid #ffffff;
        }
        
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 15px;
            }
            
            .nav-links {
                justify-content: center;
                flex-wrap: wrap;
            }
            
            .dashboard {
                gap: 30px;
            }
            
            .card {
                width: 90%;
                max-width: 300px;
            }
            
            .main-title {
                font-size: 2.5rem;
            }
            
            .nav-link {
                font-size: 16px;
                padding: 8px 12px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo">Aprecia</div>
            <div class="nav-links">
                <a href="#" class="nav-link">Inicio</a>
                <a href="#" class="nav-link">Creditos de creadores</a>
            </div>
        </div>
    </header>
    
    <div class="container">
        <h1 class="main-title">Mi Dashboard</h1>
        
        <div class="dashboard">
            <a href="#" class="card" id="games-card" tabindex="0" aria-label="Sección de Juegos">
                <div class="card-image games-image"></div>
                <div class="card-content">
                    <h2 class="card-title">Juegos</h2>
                    <p class="card-desc">aprende con practica lo principal de braile como el abecedario.</p>
                    <button class="card-button">Explorar</button>
                </div>
            </a>
            
            <a href="#" class="card" id="books-card" tabindex="0" aria-label="Sección de Libros">
                <div class="card-image books-image"></div>
                <div class="card-content">
                    <h2 class="card-title">Libros</h2>
                    <p class="card-desc">escucha diferentes audios de libros fantasticos </p>
                    <button class="card-button">Descubrir</button>
                </div>
            </a>
        </div>
    </div>
    
    <div class="footer">
        Este entorno fue dado a entender para mejorar sus fanciones.
    </div>

    <script>
        document.getElementById('games-card').addEventListener('click', function(e) {
            if (e.target.tagName !== 'BUTTON') {
                alert('Accediendo a la sección de Juegos');
                // Aquí puedes agregar la navegación a la página de juegos
                window.location.href = 'juegos/game_1.php';
            }
        });
        
        document.getElementById('books-card').addEventListener('click', function(e) {
            if (e.target.tagName !== 'BUTTON') {
                alert('Accediendo a la sección de Libros');
                // Aquí puedes agregar la navegación a la página de libros
            }
        });
        
        document.querySelectorAll('.card-button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                if (this.parentNode.parentNode.id === 'games-card') {
                    alert('Explorando la sección de Juegos');
                } else if (this.parentNode.parentNode.id === 'books-card') {
                    alert('Descubriendo la sección de Libros');
                }
            });
        });
        
        // Manejo de teclado para accesibilidad
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    if (this.id === 'games-card') {
                        alert('Accediendo a la sección de Juegos');
                    } else if (this.id === 'books-card') {
                        alert('Accediendo a la sección de Libros');
                    }
                }
            });
        });
    </script>
</body>
</html>