<?php
include 'conexion.php';

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $ci = $_POST['ci'];
    $telefono = $_POST['telefono'];
    $nombre_tutor = $_POST['nombre_tutor'];
    $telefono_tutor = $_POST['telefono_tutor'];
    $ci_tutor = $_POST['ci_tutor'];

    $sql = "UPDATE estudiantes SET 
            nombres='$nombres', apellidos='$apellidos', ci='$ci', telefono='$telefono',
            nombre_tutor='$nombre_tutor', telefono_tutor='$telefono_tutor', ci_tutor='$ci_tutor',
            updated_at=CURRENT_TIMESTAMP
            WHERE id=$id";

    if ($conexion->query($sql) === TRUE) {
        echo "Estudiante actualizado correctamente.";
    } else {
        echo "Error al actualizar: " . $conexion->error;
    }
}

$resultado = $conexion->query("SELECT * FROM estudiantes WHERE id=$id");
$fila = $resultado->fetch_assoc();
?>

<form method="POST" action="">
    Nombres: <input type="text" name="nombres" value="<?php echo $fila['nombres']; ?>" required><br>
    Apellidos: <input type="text" name="apellidos" value="<?php echo $fila['apellidos']; ?>" required><br>
    CI: <input type="text" name="ci" value="<?php echo $fila['ci']; ?>" required><br>
    Teléfono: <input type="text" name="telefono" value="<?php echo $fila['telefono']; ?>" required><br>
    Nombre Tutor: <input type="text" name="nombre_tutor" value="<?php echo $fila['nombre_tutor']; ?>" required><br>
    Teléfono Tutor: <input type="text" name="telefono_tutor" value="<?php echo $fila['telefono_tutor']; ?>" required><br>
    CI Tutor: <input type="text" name="ci_tutor" value="<?php echo $fila['ci_tutor']; ?>"><br>
    <button type="submit">Actualizar Estudiante</button>
</form>
<a href="estudiante.php">
    <button>🔙 Volver al listado</button>
</a>