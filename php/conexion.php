<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ESTAS LINEAS DE CODIGO ES PARA REALIZAR LA CONEXION A LA BASE DE DATOS

$conexion = new mysqli("localhost", "root", "", "barberia");

// CON ESTE BLOQUE DE CODIGO ME DOY CUENTA SI LA CONEXION SI SE DA O NO Y ME MUESTRA EN PANTALLA

if ($conexion->connect_error) {
    die("Error al conectar: " . $conexion->connect_error);
} else {
    echo "✅ Conexión exitosa a la base de datos.";
}
?>