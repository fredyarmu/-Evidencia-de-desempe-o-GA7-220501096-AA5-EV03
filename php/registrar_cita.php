<?php
// Incluir la conexión a la base de datos
include 'conexion.php';

// Validar si se enviaron los datos
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $servicio = $_POST['servicio'] ?? '';
    $barbero = $_POST['barbero'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $hora = $_POST['hora'] ?? '';

    // Validar campos obligatorios
    if (empty($servicio) || empty($barbero) || empty($fecha) || empty($hora)) {
        die("Todos los campos son obligatorios.");
    }

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("INSERT INTO citas (servicio, barbero, fecha, hora) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $servicio, $barbero, $fecha, $hora);

    if ($stmt->execute()) {
        echo "<script>
                alert('Cita registrada con éxito.');
                window.location.href = '../Clientes.html';
              </script>";
    } else {
        echo "Error al registrar la cita: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método no permitido.";
}
?>