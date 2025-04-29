<?php
$conexion = new mysqli("localhost", "root", "rafa1909", "hackaton");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
