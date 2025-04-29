<?php
function init(PDO $conn) {

}

$host = "localhost";
$user = "root";
$password = "1234"; // ← tu contraseña correcta
$dbname = "hackaton"; // ← la base que sí estás usando

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    die();
}
?>
