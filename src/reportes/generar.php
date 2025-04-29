<?php
require __DIR__.'/../../vendor/autoload.php'; // Asegúrate de haber instalado dompdf con composer

use Dompdf\Dompdf;
use Dompdf\Options;

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conexion = Connection::get();

$resultado = $conexion->query("SELECT * FROM estudiantes WHERE deleted_at IS NULL");
$total_estudiantes = $resultado->rowCount();

$titulo = "Estudiantes"; $pagina = "estudiantes";
// Comienza el almacenamiento del contenido HTML
ob_start();
?>

<!-- Aquí va tu HTML completo tal cual está, solo que dentro del archivo PHP -->
<style>
    /* Los estilos CSS van aquí, tal como están en tu código */
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

<div class="container">
    <div class="header-section">
        <div class="title-container">
            <h1>Estudiantes</h1>
            <span class="counter"><?php echo $total_estudiantes; ?></span>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            Listado de Estudiantes Activos
        </div>
        <?php if ($total_estudiantes > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>CI</th>
                        <th>Teléfono</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($resultado->fetchAll() as $fila): ?>
                        <tr>
                            <td><?php echo $fila['id']; ?></td>
                            <td><?php echo $fila['nombres'] . ' ' . $fila['apellidos']; ?></td>
                            <td><?php echo $fila['ci']; ?></td>
                            <td><?php echo $fila['telefono']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <p>No hay estudiantes registrados actualmente.</p>
                <p>Crea un nuevo estudiante para comenzar.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="footer">
        <p>© <?php echo date('Y'); ?> Sistema de Gestión de Estudiantes</p>
    </div>
</div>

<?php
$contenido = ob_get_clean(); // Guarda el contenido generado

// Configurar opciones de dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);

// Crear el objeto dompdf y cargar el contenido
$dompdf = new Dompdf($options);
$dompdf->loadHtml($contenido);

// (Opcional) Configurar el tamaño y la orientación del PDF
$dompdf->setPaper('A4', 'portrait');

// Renderizar el PDF (en memoria)
$dompdf->render();

// Descargar el PDF generado
$dompdf->stream("reporte_estudiantes.pdf", array("Attachment" => 0));
?>
