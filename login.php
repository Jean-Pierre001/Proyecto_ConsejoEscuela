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
  <style>
    /* Contenedor que cubre toda la pantalla con la imagen de fondo */
    body, html {
      height: 100%;
      margin: 0;
      padding: 0;
      overflow: hidden; /* Opcional para evitar scroll si no quieres */
    }
    .background-image {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: url('assets/images/patagones.jfif') no-repeat center center/cover;
      filter: blur(0px); <!-- Cambia el valor para aumentar o disminuir el desenfoque -->
      z-index: -1; /* Para que esté detrás */
      user-select: none;
      -webkit-user-select: none;
    }
    /* Contenedor del login centrado y por encima */
    .login-container {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      z-index: 1;
    }
  </style>
</head>
<body>
  <div class="background-image"></div>

  <div class="login-container">
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
