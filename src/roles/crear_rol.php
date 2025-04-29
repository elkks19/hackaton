<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conexion = Connection::get();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];

    $sql = "INSERT INTO roles (nombre) VALUES ('$nombre')";

    if ($conexion->query($sql) === TRUE) {
        echo "Rol creado correctamente.";
    } else {
        echo "Error: " . $conexion->error;
    }
}
?>

<form method="POST" action="">
    Nombre del Rol: <input type="text" name="nombre" required><br><br>
    <button type="submit">Guardar Rol</button>
</form>
<a href="roles.php">
    <button>🔙 Volver al listado</button>
</a>
