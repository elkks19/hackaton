<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #FF8C00;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .login-container {
            background-color: #FFFFFF;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            padding: 40px;
            text-align: center;
        }
        
        .logo {
            margin-bottom: 30px;
        }
        
        .logo-circle {
            width: 80px;
            height: 80px;
            background-color: #FF6600;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            color: white;
            font-size: 36px;
            font-weight: bold;
        }
        
        h1 {
            color: #FF6600;
            margin-bottom: 30px;
            font-size: 28px;
        }
        
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        
        label {
            display: block;
            color: #FF8C00;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 16px;
        }
        
        input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #FFD8B6;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        input:focus {
            border-color: #FF6600;
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 102, 0, 0.2);
        }
        
        button {
            background-color: #FF6600;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 14px 20px;
            width: 100%;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        button:hover {
            background-color: #E65C00;
        }
        
        .links {
            margin-top: 25px;
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }
        
        .links a {
            color: #FF8C00;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .links a:hover {
            color: #FF6600;
            text-decoration: underline;
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 30px 0;
            color: #999;
        }
        
        .divider::before, .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #FFD8B6;
        }
        
        .divider span {
            padding: 0 10px;
            font-size: 14px;
        }
        
        .social-login {
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        
        .social-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #FFF0E0;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s;
            border: 1px solid #FFD8B6;
        }
        
        .social-btn:hover {
            background-color: #FFD8B6;
        }
        
        .social-icon {
            color: #FF6600;
            font-size: 22px;
        }
        
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }
            
            h1 {
                font-size: 24px;
            }
            
            .links {
                flex-direction: column;
                gap: 15px;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <div class="logo-circle">M</div>
        </div>
        
        <h1>Iniciar Sesión</h1>
        
        <form>
            <div class="form-group">
                <label for="username">Usuario o Email</label>
                <input type="text" id="username" name="username" placeholder="Ingresa tu usuario" required>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
            </div>
            
            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            if (username && password) {
                alert('Iniciando sesión...');
				document.location.href = 'src/inicio/index.php'
            } else {
                alert('Por favor completa todos los campos');
            }
        });
    </script>
</body>
</html>
