<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conexion = Connection::get();

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];

    $sql = "UPDATE roles SET nombre='$nombre' WHERE id=$id";

    if ($conexion->query($sql) === TRUE) {
        echo "Rol actualizado correctamente.";
    } else {
        echo "Error actualizando: " . $conexion->error;
    }
}

$resultado = $conexion->query("SELECT * FROM roles WHERE id=$id");
$fila = $resultado->fetch_assoc();
?>

<form method="POST" action="">
    Nombre del Rol: <input type="text" name="nombre" value="<?php echo $fila['nombre']; ?>" required><br><br>
    <button type="submit">Actualizar Rol</button>
</form>
<a href="roles.php">
    <button>🔙 Volver al listado</button>
</a>
