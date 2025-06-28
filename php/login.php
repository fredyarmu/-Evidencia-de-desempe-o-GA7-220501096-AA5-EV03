<?php
session_start();

/* === Credenciales estáticas para empleados sin registro === */
const EMP_USER = 'empleado';
const EMP_PASS = 'BarberShop2025';
/* ========================================================== */

// Rechaza accesos que no sean POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../inicio.html');
    exit();
}

// Datos enviados por el formulario
$usuarioIngresado = trim($_POST['username'] ?? '');
$claveIngresada   = trim($_POST['password'] ?? '');

/* 1️⃣ Autenticación RÁPIDA con credenciales fijas */
if ($usuarioIngresado === EMP_USER && $claveIngresada === EMP_PASS) {
    // Si en un futuro deseas mostrar datos personalizados, puedes dejar id_persona en 0
    $_SESSION['id_persona'] = 0;
    $_SESSION['rol']        = 'Empleado';

    header('Location: ../Empleados.html');
    exit();
}

/* 2️⃣ Si no coincide, continúa el flujo original en la base de datos */
require 'conexion.php';

$usuario = $usuarioIngresado;
$clave   = $claveIngresada;

$sql = "SELECT p.Id_persona, p.Password, p.Numero_documento, p.CambioPassword,
               r.Nombre AS rol
        FROM personas p
        JOIN personas_roles pr ON p.Id_persona = pr.Id_persona
        JOIN roles r           ON pr.Id_rol     = r.Id_rol
        WHERE p.Numero_documento = :u OR p.Correo = :u";

$stmt = $pdo->prepare($sql);
$stmt->execute(['u' => $usuario]);
$persona = $stmt->fetch(PDO::FETCH_ASSOC);

if ($persona && password_verify($clave, $persona['Password'])) {
    // session_start(); // ya se ejecutó arriba
    $_SESSION['id_persona'] = $persona['Id_persona'];
    $_SESSION['rol']        = $persona['rol'];

    // Primera vez ➜ obliga a crear nueva contraseña
    if (!$persona['CambioPassword']) {
        header('Location: ./crear_contraseña.php');
        exit();
    }

    // Redirección normal según rol
    header('Location: ' . ($persona['rol'] === 'Empleado' ? '../Empleados.html' : '../clientes.html'));
    exit();
}

/* 3️⃣ Fallo total → vuelve al login con mensaje de error */
header('Location: ../inicio.html?error=login');
exit();
?>
