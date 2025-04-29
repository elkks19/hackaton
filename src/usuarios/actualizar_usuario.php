<?php

require_once __DIR__ . '/../index.php';

use App\DB\Connection;

$conexion = Connection::get();

$id = $_GET['id'];

// Obtener roles
$roles = $conexion->query("SELECT * FROM roles");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rol_id = $_POST['rol_id'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $ci = $_POST['ci'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];

    $sql = "UPDATE usuarios SET 
            rol_id='$rol_id', nombres='$nombres', apellidos='$apellidos', 
            telefono='$telefono', direccion='$direccion', ci='$ci', fecha_nacimiento='$fecha_nacimiento', 
            updated_at=CURRENT_TIMESTAMP
            WHERE id=$id";

    if ($conexion->query($sql) === TRUE) {
        echo "Usuario actualizado correctamente.";
    } else {
        echo "Error actualizando: " . $conexion->error;
    }
}

// Datos actuales del usuario
$resultado = $conexion->query("SELECT * FROM usuarios WHERE id=$id");
$fila = $resultado->fetch_assoc();
?>

<form method="POST" action="">
    Rol: 
    <select name="rol_id" required>
        <?php while ($rol = $roles->fetch_assoc()): ?>
            <option value="<?php echo $rol['id']; ?>" <?php echo ($rol['id'] == $fila['rol_id']) ? 'selected' : ''; ?>>
                <?php echo $rol['nombre']; ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>

    Nombres: <input type="text" name="nombres" value="<?php echo $fila['nombres']; ?>" required><br>
    Apellidos: <input type="text" name="apellidos" value="<?php echo $fila['apellidos']; ?>" required><br>
    Teléfono: <input type="text" name="telefono" value="<?php echo $fila['telefono']; ?>" required><br>
    Dirección: <input type="text" name="direccion" value="<?php echo $fila['direccion']; ?>" required><br>
    CI: <input type="text" name="ci" value="<?php echo $fila['ci']; ?>" required><br>
    Fecha de Nacimiento: <input type="date" name="fecha_nacimiento" value="<?php echo $fila['fecha_nacimiento']; ?>" required><br><br>

    <button type="submit">Actualizar Usuario</button>
</form>

<a href="usuarios.php">
    <button>🔙 Volver al listado</button>
</a>
