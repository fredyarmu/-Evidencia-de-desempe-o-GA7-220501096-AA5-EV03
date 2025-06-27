<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../inicio.html'); exit();
}

require 'conexion.php';

$usuario = $_POST['username'] ?? '';
$clave   = $_POST['password'] ?? '';

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
    session_start();
    $_SESSION['id_persona'] = $persona['Id_persona'];
    $_SESSION['rol']        = $persona['rol'];

    /* 1ª vez ➜ redirige a cambio de contraseña */
    if (!$persona['CambioPassword']) {
        header('Location: ../crear_contraseña.php');
        exit();
    }

    /* Redirección normal */
    header('Location: ' . ($persona['rol'] === 'Empleado' ? '../Empleados.html'
                                                          : '../clientes.html'));
    exit();
}

header('Location: ../inicio.html?error=login');
exit();
?>
