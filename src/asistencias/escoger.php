<?php
$titulo = "Asistencia";
$pagina = "Asistencia";
?>

<?php ob_start(); ?>
    
    <style>
        :root {
            --primary-color: #ff7d36; /* Naranja primario */
            --primary-hover: #e66b28; /* Naranja oscuro para hover */
            --danger-color: #ff4d4d; /* Rojo-naranja para botones de peligro */
            --danger-hover: #e63939; /* Rojo-naranja más oscuro para hover */
            --success-color: #ffb74d; /* Naranja claro para éxito */
            --success-hover: #e6a642; /* Naranja claro más oscuro para hover */
            --gray-light: #fff5eb; /* Gris con tinte naranja muy claro */
            --gray-medium: #ffe0cc; /* Gris con tinte naranja claro */
            --gray-dark: #996033; /* Gris con tinte naranja oscuro */
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(255, 125, 54, 0.15);
            --transition: all 0.3s ease;
            --primary: #FF7A00;
            --primary-light: #FF9A40;
            --primary-dark: #E06500;
            --secondary: #FFEAD7;
            --accent: #FFC380;
            --text-dark: #333333;
            --text-light: #FFFFFF;
            --bg-light: #FFF9F5;
            --shadow: rgba(255, 122, 0, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f9f2ec;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
            color: #5a3a20;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .header p {
            font-size: 1.2rem;
            color: var(--gray-dark);
        }

        .selection-container {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 3rem;
            flex-wrap: wrap;
        }

        .selection-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            width: 300px;
            overflow: hidden;
            transition: var(--transition);
            cursor: pointer;
            text-align: center;
        }

        .selection-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 20px rgba(255, 125, 54, 0.2);
        }

        .card-icon {
            background-color: var(--primary-color);
            color: white;
            padding: 2rem;
            font-size: 3rem;
        }

        .card-content {
            padding: 2rem 1.5rem;
        }

        .card-content h2 {
            margin-bottom: 1rem;
            color: #5a3a20;
            font-size: 1.5rem;
        }

        .card-content p {
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
        }

        .footer {
            text-align: center;
            padding: 2rem 0;
            margin-top: 4rem;
            color: var(--gray-dark);
            font-size: 0.9rem;
            border-top: 1px solid var(--gray-medium);
        }

        @media screen and (max-width: 768px) {
            .selection-container {
                flex-direction: column;
                align-items: center;
            }
            
            .selection-card {
                width: 100%;
                max-width: 350px;
            }
        }
    </style>
    <div class="container">
        <header class="header">
            <h1>Sistema de Asistencia Escolar</h1>
            <p>Seleccione el tipo de asistencia que desea gestionar</p>
        </header>

        <main>
            <div class="selection-container">
                <div class="selection-card" onclick="location.href='asistencia_profesores.php';">
                    <div class="card-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="card-content">
                        <h2>Asistencia de Profesores</h2>
                        <p>Gestione la asistencia del cuerpo docente, registre llegadas, salidas y ausencias justificadas.</p>
                        <a href="asistencia_profesores.php" class="btn">Acceder</a>
                    </div>
                </div>

                <div class="selection-card" onclick="location.href='asistencia_estudiantes.php';">
                    <div class="card-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="card-content">
                        <h2>Asistencia de Estudiantes</h2>
                        <p>Registre la asistencia de los estudiantes por clase, genere reportes y notifique a los padres.</p>
                        <a href="asistencia_estudiantes.php" class="btn">Acceder</a>
                    </div>
                </div>
            </div>
        </main>

        <footer class="footer">
            <p>&copy; 2025 Sistema de Asistencia Escolar - Todos los derechos reservados</p>
        </footer>
    </div>
    <?php
    $contenido = ob_get_clean(); // Guarda el contenido generado
    include '../layout/layout.php'; // Muestra el layout con el contenido insertado
    ?>