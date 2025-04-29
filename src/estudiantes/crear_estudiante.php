<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $ci = $_POST['ci'];
    $telefono = $_POST['telefono'];
    $nombre_tutor = $_POST['nombre_tutor'];
    $telefono_tutor = $_POST['telefono_tutor'];
    $ci_tutor = $_POST['ci_tutor'];

    $sql = "INSERT INTO estudiantes (nombres, apellidos, ci, telefono, nombre_tutor, telefono_tutor, ci_tutor)
            VALUES ('$nombres', '$apellidos', '$ci', '$telefono', '$nombre_tutor', '$telefono_tutor', '$ci_tutor')";

    if ($conexion->query($sql) === TRUE) {
        echo "Estudiante registrado correctamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>

<form method="POST" action="">
    Nombres: <input type="text" name="nombres" required><br>
    Apellidos: <input type="text" name="apellidos" required><br>
    CI: <input type="text" name="ci" required><br>
    Teléfono: <input type="text" name="telefono" required><br>
    Nombre del Tutor: <input type="text" name="nombre_tutor" required><br>
    Teléfono del Tutor: <input type="text" name="telefono_tutor" required><br>
    CI del Tutor: <input type="text" name="ci_tutor"><br>
    <button type="submit">Guardar Estudiante</button>
</form>

<a href="estudiante.php">
    <button>🔙 Volver al listado</button>
</a>
