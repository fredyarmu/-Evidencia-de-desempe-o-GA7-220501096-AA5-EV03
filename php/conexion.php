<?php
$host = 'localhost';
$db = 'barberia'; // nombre de tu base de datos
$user = 'root'; // usuario de Laragon
$pass = ''; // contraseña vacía por defecto en Laragon

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
