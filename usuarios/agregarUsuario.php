<!-- archivo: registrar.php -->
<form method="POST">
    <label>Usuario:</label>
    <input type="text" name="usuario" required><br>
    <label>Contraseña:</label>
    <input type="password" name="contrasena" required><br>
    <button type="submit">Registrar</button>
</form>

<?php
$conexion = new mysqli("localhost", "tu_usuario", "tu_contraseña", "nombre_base_de_datos");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $stmt = $conexion->prepare("INSERT INTO usuarios (usuario, contrasena) VALUES (?, ?)");
    $stmt->bind_param("ss", $usuario, $hash);

    if ($stmt->execute()) {
        echo "✅ Usuario registrado con éxito.";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>
