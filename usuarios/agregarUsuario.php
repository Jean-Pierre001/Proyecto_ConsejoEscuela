<?php
require_once '../baseDatos/conexion.php';

$cue = isset($_POST['id_usuarios']) ? $_POST['id_usuarios'] : '';

$sql = "SELECT id, CUE, turno, servicio, direccion, localidad, telefono, correo_electronico, directivo FROM escuelas WHERE 1=1";

// Filtrar por CUE si se ha ingresado uno
if ($cue) {
    $sql .= " AND CUE LIKE :cue";
}

try {
    $stmt = $pdo->prepare($sql);
    if ($cue) {
        $stmt->bindValue(':cue', $cue . '%');
    }
    $stmt->execute();
} catch (PDOException $e) {
    die("Error al consultar la base de datos: " . $e->getMessage());
}
?>

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
