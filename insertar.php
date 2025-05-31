<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configurar conexión
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "barberia";

// Conexión a la base de datos
$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Validar que los datos llegan por POST (opcional pero recomendable)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtener datos del formulario con seguridad (trim y escapes si quieres)
    $PrimerNombre = $_POST['Primer_nombre'] ?? '';
    $SegundoNombre = $_POST['Segundo_nombre'] ?? '';
    $PrimerApellido = $_POST['Primer_apellido'] ?? '';
    $SegundoApellido = $_POST['Segundo_apellido'] ?? '';
    $FechaNacimiento = $_POST['Fecha_Nacimiento'] ?? '';
    $Correo = $_POST['Correo'] ?? '';
    $Telefono = $_POST['Telefono'] ?? '';
    $tipo_documento = $_POST['tipo_documento'] ?? '';
    $Numero_documento = $_POST['Numero_documento'] ?? '';
    $sexo = $_POST['sexo'] ?? '';
    $password = $_POST['password'] ?? '';

    // Encriptar la contraseña antes de guardar (muy importante)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta con placeholders (?)
    $stmt = $conexion->prepare("INSERT INTO personas 
        (PrimerNombre, SegundoNombre, PrimerApellido, SegundoApellido, fechaNacimiento, gmail, telefono, tipo_documento, numero_documento, sexo, password) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Verificar que prepare no devolvió false (error en consulta)
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    // Asociar parámetros, tipos 's' para string, todos tus datos son texto
    $stmt->bind_param("sssssssssss", 
        $PrimerNombre, $SegundoNombre, $PrimerApellido, $SegundoApellido, $FechaNacimiento,
        $Correo, $Telefono, $tipo_documento, $Numero_documento, $sexo, $hashedPassword);

    // Ejecutar y verificar resultado
    if ($stmt->execute()) {
        echo "✅ Registro insertado correctamente.";
    } else {
        echo "❌ Error al insertar: " . $stmt->error;
    }

    $stmt->close();

} else {
    echo "No se enviaron datos por POST.";
}

$conexion->close();
?>