<?php
$conexion = new mysqli("localhost", "root", "", "barberia");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>