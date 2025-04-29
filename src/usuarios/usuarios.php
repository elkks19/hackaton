<?php
$titulo = "Personal";
$pagina = "Personal";
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

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.title-container {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.title-container h1 {
    margin: 0;
    font-size: 1.8rem;
    color: #5a3a20; /* Marrón-naranja para títulos */
}

.title-container .counter {
    background-color: var(--primary-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: bold;
}

.nav-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background-color: var(--primary-color);
    color: white;
    text-decoration: none;
    border-radius: var(--border-radius);
    font-weight: 500;
    transition: var(--transition);
    border: none;
    cursor: pointer;
}

.btn:hover {
    background-color: var(--primary-hover);
    transform: translateY(-2px);
}

.btn-delete {
    background-color: var(--danger-color);
}

.btn-delete:hover {
    background-color: var(--danger-hover);
}

.btn-view {
    background-color: #ff9e66; /* Naranja más claro para botones de visualización */
}

.btn-view:hover {
    background-color: #e68c57; /* Naranja más claro oscurecido para hover */
}

.btn-edit {
    background-color: var(--primary-color);
}

.btn-sm {
    padding: 0.35rem 0.7rem;
    font-size: 0.85rem;
}

.search-container {
    display: flex;
    margin: 1.5rem 0;
    max-width: 600px;
    position: relative;
}

.search-container input {
    flex: 1;
    padding: 0.75rem 1rem;
    border: 1px solid var(--gray-medium);
    border-radius: var(--border-radius);
    font-size: 1rem;
    width: 100%;
    transition: var(--transition);
}

.search-container input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(255, 125, 54, 0.2);
}

.search-container button {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--gray-dark);
    cursor: pointer;
    transition: var(--transition);
}

.search-container button:hover {
    color: var(--primary-color);
}

.table-container {
    background-color: white;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    overflow: hidden;
    margin-bottom: 2rem;
}

.table-header {
    background-color: var(--primary-color);
    color: white;
    padding: 1rem 1.5rem;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 1rem 1.5rem;
    text-align: left;
    border-bottom: 1px solid var(--gray-medium);
}

th {
    background-color: var(--gray-light);
    font-weight: 600;
    color: #5a3a20; /* Marrón-naranja para encabezados de tabla */
}

tr:last-child td {
    border-bottom: none;
}

tr:hover {
    background-color: var(--gray-light);
}

.actions {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
    flex-wrap: wrap;
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--gray-dark);
}

.empty-state i {
    font-size: 4rem;
    color: var(--gray-medium);
    margin-bottom: 1rem;
    opacity: 0.7;
}

.empty-state p {
    margin: 0.5rem 0;
    font-size: 1.1rem;
}

.footer {
    text-align: center;
    padding: 1.5rem 0;
    color: var(--gray-dark);
    font-size: 0.9rem;
    border-top: 1px solid var(--gray-medium);
    margin-top: 2rem;
}

@media screen and (max-width: 768px) {
    .actions {
        flex-direction: column;
    }
    
    .header-section {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .nav-buttons {
        width: 100%;
        margin-top: 1rem;
    }
    
    th, td {
        padding: 0.75rem;
    }
}
</style>

    <?php
	require_once __DIR__ . '/../index.php';

	use App\DB\Connection;

	$conexion = Connection::get();
    $resultado = $conexion->query("
        SELECT usuarios.*, roles.nombre AS rol_nombre 
        FROM usuarios 
        INNER JOIN roles ON usuarios.rol_id = roles.id
        WHERE usuarios.deleted_at IS NULL
    ");
    $total_usuarios = $resultado->rowCount();
    ?>

    <div class="container">
        <header>
            <h1><i class="fas fa-users"></i> Sistema de Gestión de Usuarios</h1>
            <div>
                <span class="date-display"><?php echo date('d/m/Y'); ?></span>
            </div>
        </header>

        <div class="nav-buttons">
            <a href="crear_usuario.php" class="btn">
                <i class="fas fa-plus"></i> Crear Nuevo Usuario
            </a>
            <a href="usuarios_eliminados.php" class="btn btn-delete">
                <i class="fas fa-trash-alt"></i> Ver Usuarios Eliminados
            </a>
        </div>

        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Buscar usuarios...">
            <button id="searchButton"><i class="fas fa-search"></i></button>
        </div>

        <div class="table-container">
            <h2>Listado de Usuarios Activos (<?php echo $total_usuarios; ?>)</h2>
            
            <?php if ($total_usuarios > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Rol</th>
                            <th>CI</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultado->fetchAll() as $fila): ?>
                            <tr>
                                <td><?php echo $fila['id']; ?></td>
                                <td><?php echo $fila['nombres'] . ' ' . $fila['apellidos']; ?></td>
                                <td>
                                    <?php 
                                    $rol_class = '';
                                    switch(strtolower($fila['rol_nombre'])) {
                                        case 'admin':
                                        case 'administrador': 
                                            $rol_class = 'role-admin'; 
                                            break;
                                        case 'usuario': 
                                        case 'user': 
                                            $rol_class = 'role-user'; 
                                            break;
                                        case 'editor': 
                                            $rol_class = 'role-editor'; 
                                            break;
                                    }
                                    ?>
                                    <span class="role-badge <?php echo $rol_class; ?>">
                                        <?php echo $fila['rol_nombre']; ?>
                                    </span>
                                </td>
                                <td><?php echo $fila['ci']; ?></td>
                                <td><?php echo $fila['telefono']; ?></td>
                                <td class="actions">
                                    <a href="ver_usuario.php?id=<?php echo $fila['id']; ?>" class="btn btn-sm btn-view">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                    <a href="actualizar_usuario.php?id=<?php echo $fila['id']; ?>" class="btn btn-sm btn-edit">
                                        <i class="fas fa-pencil-alt"></i> Editar
                                    </a>
                                    <a href="eliminar_usuario.php?id=<?php echo $fila['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar a este usuario?');" class="btn btn-sm btn-delete">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-user-slash" style="font-size: 48px; margin-bottom: 15px;"></i>
                    <p>No hay usuarios registrados actualmente.</p>
                    <p>Crea un nuevo usuario para comenzar.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="footer">
            <p>© <?php echo date('Y'); ?> Sistema de Gestión de Usuarios</p>
        </div>
    </div>

    <script>
        // Script para la funcionalidad de búsqueda
        document.getElementById('searchButton').addEventListener('click', function() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if(text.includes(input)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Buscar también al presionar Enter
        document.getElementById('searchInput').addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                document.getElementById('searchButton').click();
            }
        });
    </script>
    <?php
    $contenido = ob_get_clean(); // Guarda el contenido generado
    include '../layout/layout.php'; // Muestra el layout con el contenido insertado
    ?>
