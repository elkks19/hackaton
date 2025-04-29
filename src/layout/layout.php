<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de APRECIA</title>
    <style>
        :root {
            --primary: #4F46E5;
            --primary-dark: #4338CA;
            --primary-light: #EEF2FF;
            --secondary: #6B7280;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --text: #1F2937;
            --text-light: #6B7280;
            --background: #F9FAFB;
            --sidebar: #111827;
            --sidebar-hover: #1F2937;
            --border: #E5E7EB;
            --card: #FFFFFF;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: var(--sidebar);
            color: white;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            position: fixed;
            height: 100vh;
            z-index: 100;
        }
        
        .sidebar-header {
            padding: 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .logo {
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .sidebar-menu {
            padding: 1rem 0;
            flex: 1;
            overflow-y: auto;
        }
        
        .menu-category {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 1.25rem 1.5rem 0.5rem;
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.2s ease;
            margin: 0.25rem 0;
        }
        
        .menu-item:hover, .menu-item.active {
            background-color: var(--sidebar-hover);
            color: white;
            border-left: 4px solid var(--primary);
            padding-left: calc(1.5rem - 4px);
        }
        
        .menu-icon {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
        }
        
        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        .user-details {
            font-size: 0.9rem;
        }
        
        .user-name {
            font-weight: 500;
        }
        
        .user-role {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.5);
        }
        
        .logout-btn {
            color: rgba(255, 255, 255, 0.7);
            background: none;
            border: none;
            cursor: pointer;
            transition: color 0.2s ease;
        }
        
        .logout-btn:hover {
            color: white;
        }
        
        /* Content Area Styles */
        .content-wrapper {
            flex: 1;
            margin-left: 250px;
            width: calc(100% - 250px);
            transition: all 0.3s ease;
        }
        
        .topbar {
            background-color: white;
            border-bottom: 1px solid var(--border);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 64px;
        }
        
        .page-title {
            font-size: 1.25rem;
            font-weight: 600;
        }
        
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text);
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        .main-content {
            padding: 2rem;
            min-height: calc(100vh - 64px);
        }
        
        /* Utility for showing active page */
        .page-estudiantes .menu-estudiantes,
        .page-cursos .menu-cursos,
        .page-asistencia .menu-asistencia,
        .page-profesores .menu-profesores,
        .page-pagos .menu-pagos,
        .page-reportes .menu-reportes,
        .page-usuarios .menu-usuarios,
        .page-configuracion .menu-configuracion,
        .page-eliminados .menu-eliminados,
        .page-dashboard .menu-dashboard {
            background-color: var(--sidebar-hover);
            color: white;
            border-left: 4px solid var(--primary);
            padding-left: calc(1.5rem - 4px);
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            .sidebar {
                width: 80px;
                overflow: hidden;
            }
            
            .sidebar.expanded {
                width: 250px;
            }
            
            .logo-text, .menu-text, .menu-category, .user-details {
                opacity: 0;
                transition: opacity 0.3s ease;
            }
            
            .sidebar.expanded .logo-text,
            .sidebar.expanded .menu-text,
            .sidebar.expanded .menu-category,
            .sidebar.expanded .user-details {
                opacity: 1;
            }
            
            .content-wrapper {
                margin-left: 80px;
                width: calc(100% - 80px);
            }
            
            .content-wrapper.sidebar-expanded {
                margin-left: 250px;
                width: calc(100% - 250px);
            }
            
            .menu-toggle {
                display: block;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                position: fixed;
                left: -250px;
            }
            
            .sidebar.expanded {
                width: 250px;
                left: 0;
            }
            
            .content-wrapper {
                margin-left: 0;
                width: 100%;
            }
            
            .content-wrapper.sidebar-expanded {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body class="page-<?= $pagina ?>">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="dashboard.php" class="logo">
                <span>🎓</span>
                <span class="logo-text">APRECIA</span>
            </a>
        </div>
        
        <div class="sidebar-menu">
            <div class="menu-category">Principal</div>
            <a href="../inicio/index.php" class="menu-item menu-dashboard">
                <span class="menu-icon">📊</span>
                <span class="menu-text">Dashboard</span>
            </a>
            <a href="../estudiantes/estudiante.php" class="menu-item menu-estudiantes">
                <span class="menu-icon">👨‍🎓</span>
                <span class="menu-text">Estudiantes</span>
            </a>
            <a href="curso.php" class="menu-item menu-cursos">
                <span class="menu-icon">📚</span>
                <span class="menu-text">Cursos</span>
            </a>
            <a href="../asistencias/escoger.php" class="menu-item menu-asistencia">
                <span class="menu-icon">📋</span>
                <span class="menu-text">Asistencia</span>
            </a>
            
            <div class="menu-category">Administración</div>
            <a href="../usuarios/usuarios.php" class="menu-item menu-profesores">
                <span class="menu-icon">👨‍🏫</span>
                <span class="menu-text">Personal</span>
            </a>
            <a href="reportes.php" class="menu-item menu-reportes">
                <span class="menu-icon">📈</span>
                <span class="menu-text">Reportes</span>
            </a>
        </div>
        
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">A</div>
                <div class="user-details">
                    <div class="user-name">Admin</div>
                    <div class="user-role">Administrador</div>
                </div>
            </div>
            <a href="logout.php" class="logout-btn">
                <span>🚪</span>
            </a>
        </div>
    </aside>
    
    <!-- Content Wrapper -->
    <div class="content-wrapper" id="content-wrapper">
        <header class="topbar">
            <button class="menu-toggle" id="menuToggle">
                <span>☰</span>
            </button>
            <h1 class="page-title"><?= $titulo ?></h1>
            <div class="topbar-actions">
                <!-- Espacio para acciones adicionales en la barra superior -->
            </div>
        </header>
        
        <main class="main-content">
            <!-- CONTENIDO DE LA PÁGINA SE INSERTARÁ AQUÍ -->
            <div id="page-content">
                <!-- Este es un contenido de ejemplo que será reemplazado -->
                <div id="page-content">
                    <?= $contenido ?>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        // Toggle sidebar
        const sidebar = document.getElementById('sidebar');
        const contentWrapper = document.getElementById('content-wrapper');
        const menuToggle = document.getElementById('menuToggle');
        
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('expanded');
            contentWrapper.classList.toggle('sidebar-expanded');
        });
        
        // Responsive behavior for sidebar
        function checkWidth() {
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('expanded');
                contentWrapper.classList.remove('sidebar-expanded');
            } else if (window.innerWidth <= 1024) {
                // Para tablets, mantener sidebar colapsado pero visible
                sidebar.classList.remove('expanded');
                contentWrapper.classList.remove('sidebar-expanded');
            }
        }
        
        window.addEventListener('resize', checkWidth);
        checkWidth();
    </script>
</body>
</html>