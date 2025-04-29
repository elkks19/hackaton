<?php
function init(PDO $conn) {

}

$host = "localhost"; // Cambia si tu host es distinto
$user = "root"; // Usuario de la base de datos
$password = ""; // Contraseña
$dbname = "prueba"; // Nombre de tu base

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    die();
}
?>
