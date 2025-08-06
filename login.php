<?php
// Configuraciones de seguridad para la sesión
ini_set('session.cookie_httponly', 1); // Bloquea acceso vía JS a la cookie de sesión
ini_set('session.use_strict_mode', 1); // No permite reuse de IDs de sesión inválidos
session_start();

require 'includes/conn.php'; // Asegúrate de que use PDO y conexión segura

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username'] ?? ''));
    $password = $_POST['password'] ?? '';

    if ($username !== '' && $password !== '') {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Seguridad: regenerar ID de sesión para prevenir session fixation
            session_regenerate_id(true);

            // Guardar variables seguras en la sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirigir al panel principal
            header("Location: index.php");
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Login - File Manager</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center vh-100">
  <form method="post" class="bg-white p-4 rounded shadow" style="width: 320px;">
    <h4 class="text-center mb-3">Iniciar Sesión</h4>
    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <div class="mb-3">
      <label for="username">Usuario</label>
      <input type="text" id="username" name="username" class="form-control" required autofocus />
    </div>
    <div class="mb-3">
      <label for="password">Contraseña</label>
      <input type="password" id="password" name="password" class="form-control" required />
    </div>
    <button class="btn btn-primary w-100">Ingresar</button>
  </form>
</div>
</body>
</html>
