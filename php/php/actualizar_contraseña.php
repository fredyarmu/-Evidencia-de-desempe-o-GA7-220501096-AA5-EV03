<?php
session_start();
require 'conexion.php';

$id     = $_SESSION['id_persona'] ?? 0;
$nueva  = $_POST['nueva']        ?? '';
$repite = $_POST['confirmar']    ?? '';

if (!$id || $nueva !== $repite) {
    die('Error en los datos');
}

$hash = password_hash($nueva, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("UPDATE personas
                       SET Password = ?, CambioPassword = 1
                       WHERE Id_persona = ?");
$stmt->execute([$hash, $id]);

header('Location: ../inicio.html?cambiada=1');
exit();
?>

