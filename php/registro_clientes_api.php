<?php
require 'conexion.php';
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// Verifica que todos los campos obligatorios estén presentes
$requiredFields = [
    'Tipo_documento', 'Numero_documento', 'Primer_nombre', 'Segundo_nombre',
    'Primer_apellido', 'Segundo_apellido', 'Fecha_Nacimiento',
    'Correo', 'Telefono', 'Sexo'
];

foreach ($requiredFields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "Falta el campo obligatorio: $field"
        ]);
        exit;
    }
}

try {
    $sql = "INSERT INTO personas (
        Tipo_documento, Numero_documento, Primer_nombre, Segundo_nombre,
        Primer_apellido, Segundo_apellido, Fecha_Nacimiento,
        Correo, Telefono, Sexo, Password
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['Tipo_documento'],
        $_POST['Numero_documento'],
        $_POST['Primer_nombre'],
        $_POST['Segundo_nombre'],
        $_POST['Primer_apellido'],
        $_POST['Segundo_apellido'],
        $_POST['Fecha_Nacimiento'],
        $_POST['Correo'],
        $_POST['Telefono'],
        $_POST['Sexo'],
        password_hash($_POST['Numero_documento'], PASSWORD_DEFAULT)
    ]);

    $persona_id = $pdo->lastInsertId();
    $pdo->prepare("INSERT INTO clientes (Id_persona, Vip) VALUES (?, 0)")->execute([$persona_id]);

    echo json_encode([
        "status" => "success",
        "message" => "Cliente registrado exitosamente",
        "id_persona" => $persona_id
    ]);
    exit;

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Error al registrar cliente: " . $e->getMessage()
    ]);
    exit;
}
