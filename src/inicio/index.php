<?php
$titulo = "Inicio";
$pagina = "Inicio";
?>

<?php ob_start(); ?>
    <style>
        :root {
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

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow-x: hidden;
            background-color: var(--bg-light);
            color: var(--text-dark);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            width: 100%;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 16px;
            color: var(--text-light);
            box-shadow: 0 6px 12px var(--shadow);
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
        }

        .logo span {
            margin-right: 10px;
            font-size: 28px;
        }

        .dashboard-title {
            font-size: 20px;
            font-weight: 500;
            margin-left: 20px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 10px var(--shadow);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-header {
            margin-bottom: 15px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 24px;
        }

        .icon-primary {
            background-color: #FFE1C6;
            color: var(--primary);
        }

        .icon-success {
            background-color: #E5F7ED;
            color: #28a745;
        }

        .icon-warning {
            background-color: #FFF8E1;
            color: #ffc107;
        }

        .icon-danger {
            background-color: #FEEBEF;
            color: #dc3545;
        }

        .stat-value {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #777;
            margin-bottom: 10px;
        }

        .stat-change {
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .change-positive {
            color: #28a745;
        }

        .change-negative {
            color: #dc3545;
        }

        .section-title {
            margin: 30px 0 20px;
            font-size: 20px;
            font-weight: 600;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .action-card {
            background-color: white;
            border-radius: 12px;
            padding: 25px 20px;
            box-shadow: 0 4px 10px var(--shadow);
            text-decoration: none;
            color: var(--text-dark);
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px var(--shadow);
        }

        .action-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .action-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .action-description {
            color: #777;
            font-size: 14px;
            line-height: 1.5;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                padding: 20px;
                text-align: center;
            }

            .dashboard-grid,
            .quick-actions {
                grid-template-columns: 1fr;
            }
            
            .container {
                padding: 10px;
            }
        }
    </style>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="logo">
                <span>🎓</span>
                <span class="logo-text">APRECIA</span>
            </div>
            <div class="dashboard-title">Panel de Control</div>
        </header>
        
        <!-- Stats Cards -->
        <div class="dashboard-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon icon-primary">👨‍🎓</div>
                </div>
                <div class="stat-value">256</div>
                <div class="stat-label">Total Estudiantes</div>
                <div class="stat-change change-positive">
                    <span>▲</span> 12% desde el mes pasado
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon icon-success">📚</div>
                </div>
                <div class="stat-value">18</div>
                <div class="stat-label">Cursos Activos</div>
                <div class="stat-change change-positive">
                    <span>▲</span> 3 nuevos este mes
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon icon-warning">👨‍🏫</div>
                </div>
                <div class="stat-value">23</div>
                <div class="stat-label">Profesores</div>
                <div class="stat-change">
                    Sin cambios este mes
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon icon-danger">📝</div>
                </div>
                <div class="stat-value">85%</div>
                <div class="stat-label">Asistencia Media</div>
                <div class="stat-change change-negative">
                    <span>▼</span> 3% respecto al mes anterior
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <h2 class="section-title">✨ Acciones Rápidas</h2>
        <div class="quick-actions">
            <a href="../estudiantes/crear_estudiante.php" class="action-card">
                <div class="action-icon icon-primary">➕</div>
                <h3 class="action-title">Registrar Estudiante</h3>
                <p class="action-description">Añadir un nuevo estudiante al sistema con toda su información.</p>
            </a>
            
            <a href="../asistencias/escoger.php" class="action-card">
                <div class="action-icon icon-success">📋</div>
                <h3 class="action-title">Registrar Asistencia</h3>
                <p class="action-description">Tomar asistencia para las clases del día actual.</p>
            </a>
            
            <a href="../reportes/index.php" class="action-card">
                <div class="action-icon icon-warning">📊</div>
                <h3 class="action-title">Generar Reportes</h3>
                <p class="action-description">Crear informes de rendimiento, asistencia y financieros.</p>
            </a>
            
        </div>
    </div>
    <?php
    $contenido = ob_get_clean(); // Guarda el contenido generado
    include '../layout/layout.php'; // Muestra el layout con el contenido insertado
    ?>
