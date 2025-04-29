<?php
// Cargar solo las variables necesarias desde .env.local
$env = parse_ini_file('.env.local');

$db_host = $env['DB_HOST'];
$db_port = $env['DB_PORT'];
$db_user = $env['DB_USER'];
$db_password = $env['DB_PASSWORD'];
$db_database = $env['DB_DATABASE'];

$conexion = new mysqli(
    $db_host,
    $db_user,
    $db_password,
    $db_database,
    (int)$db_port
);

if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}

$conexion->set_charset('utf8');
?>
