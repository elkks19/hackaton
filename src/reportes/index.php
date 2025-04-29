<?php

$titulo = "Reportes";
$pagina = "Reportes";

ob_start();
?>

<style>
    .reporte-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 3em 1em;
    }

    .button {
        background-color: #007bff;
        color: white;
        font-size: 1.1em;
        padding: 0.75em 1.5em;
        border: none;
        border-radius: 6px;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.3s ease;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .button:hover {
        background-color: #0056b3;
    }

    .button:active {
        background-color: #004185;
    }
</style>

<div class="reporte-container">
    <a href="./generar.php" class="button">
        📄 Generar reporte de estudiantes
    </a>
</div>

<?php

$contenido = ob_get_clean();
include '../layout/layout.php';
?>
