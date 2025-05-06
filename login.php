<?php require_once 'baseDatos/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Iniciar Sesión | Cooperativa La Comarca</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(to right, #c3cfe2, #f5f7fa);
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
    }

    .login-container {
      background-color: white;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #1d3a8a;
      font-weight: bold;
    }

    .form-control:focus {
      border-color: #2C9E3E;
      box-shadow: 0 0 0 0.2rem rgba(44, 158, 62, 0.25);
    }

    .btn-primary {
      background-color: #2C9E3E;
      border: none;
    }

    .btn-primary:hover {
      background-color: #23902F;
    }

    .text-muted a {
      color: #1d3a8a;
      text-decoration: none;
    }

    .text-muted a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="login-container"> 
    <h2>Iniciar Sesión</h2>
    <form action="vereficar_login.php" method="POST">
      <div class="mb-3">
        <label for="usuario" class="form-label">Usuario</label>
        <input type="text" class="form-control" id="usuario" name="usuario" required>
      </div>
      <div class="mb-3">
        <label for="contrasena" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="contrasena" name="contrasena" required>
      </div>
      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">Ingresar</button>
      </div>
    </form>
  </div>

</body>
</html>
