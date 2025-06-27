<?php
require 'conexion.php';

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


    // Ahora lo agregamos como cliente
    $persona_id = $pdo->lastInsertId();
    $pdo->prepare("INSERT INTO clientes (Id_persona, Vip) VALUES (?, 0)")->execute([$persona_id]);

   echo "<script>
    alert('Registro guardado con éxito');
    window.location.href = '../inicio.html';
</script>";
exit();


} catch (Exception $e) {
    die("Error al registrar cliente: " . $e->getMessage());
}
?>
