<?php
// Mostrar errores para depurar si algo falla

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificamos si el formulario fue enviado por POST

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Conexión a la base de datos

    $conexion = new mysqli("localhost", "root", "", "barberia");

    // estas lineas me permiten detectar si hay algun error de conexion

    if ($conexion->connect_error) {
        die("❌ Error de conexión: " . $conexion->connect_error);
    }

    // Recibir datos del formulario
    $primer_nombre = $_POST['Primer_nombre'];
    $segundo_nombre = $_POST['Segundo_nombre'];
    $primer_apellido = $_POST['Primer_apellido'];
    $segundo_apellido = $_POST['Segundo_apellido'];
    $fecha_nacimiento = $_POST['Fecha_Nacimiento'];
    $correo = $_POST['Correo'];
    $telefono = $_POST['Telefono'];
    $tipo_documento = $_POST['Tipo_documento'];
    $numero_documento = $_POST['Numero_documento'];
    $sexo = $_POST['Sexo'];

    // Prepara la consulta

    $sql = "INSERT INTO personas 
    (Primer_nombre, Segundo_nombre, Primer_apellido, Segundo_apellido, Fecha_Nacimiento, Correo, Telefono, Tipo_documento, Numero_documento, Sexo)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        die("❌ Error al preparar la consulta: " . $conexion->error);
    }

    $stmt->bind_param("ssssssssss", 
        $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido,
        $fecha_nacimiento, $correo, $telefono, $tipo_documento, $numero_documento, $sexo);

    // Ejecutar
    if ($stmt->execute()) {
        echo "✅ Registro guardado exitosamente.";
    } else {
        echo "❌ Error al guardar el registro: " . $stmt->error;
    }

    // Cerrar todo
    $stmt->close();
    $conexion->close();

} else {
    echo "⚠️ Acceso no permitido.";
}
?>