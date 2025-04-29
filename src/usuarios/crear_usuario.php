<?php
include 'conexion.php';

// Obtener roles para el select
$roles = $conexion->query("SELECT * FROM roles");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rol_id = $_POST['rol_id'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $ci = $_POST['ci'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];

    $sql = "INSERT INTO usuarios (rol_id, nombres, apellidos, telefono, direccion, ci, fecha_nacimiento)
            VALUES ('$rol_id', '$nombres', '$apellidos', '$telefono', '$direccion', '$ci', '$fecha_nacimiento')";

    if ($conexion->query($sql) === TRUE) {
        echo "Usuario creado correctamente.";
    } else {
        echo "Error: " . $conexion->error;
    }
}
?>

<form method="POST" action="">
    Rol: 
    <select name="rol_id" required>
        <?php while ($rol = $roles->fetch_assoc()): ?>
            <option value="<?php echo $rol['id']; ?>"><?php echo $rol['nombre']; ?></option>
        <?php endwhile; ?>
    </select><br><br>

    Nombres: <input type="text" name="nombres" required><br>
    Apellidos: <input type="text" name="apellidos" required><br>
    Teléfono: <input type="text" name="telefono" required><br>
    Dirección: <input type="text" name="direccion" required><br>
    CI: <input type="text" name="ci" required><br>
    Fecha de Nacimiento: <input type="date" name="fecha_nacimiento" required><br><br>

    <button type="submit">Guardar Usuario</button>
</form>

<a href="usuarios.php">
    <button>🔙 Volver al listado</button>
</a>