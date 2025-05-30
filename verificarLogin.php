<?php
session_start();
require 'baseDatos/conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $contrasena = $_POST['contrasena'];

    if ($usuario && $contrasena) {
        $stmt = $pdo->prepare("SELECT id_usuario, nombre, contrasena, tipo, correo, telefono FROM usuarios WHERE nombre = ?");
        $stmt->execute([$usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($contrasena, $user['contrasena'])) {
            $_SESSION['id_usuario'] = $user['id_usuario'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['tipo'] = $user['tipo'];
            $_SESSION['correo'] = $user['correo'];
            $_SESSION['telefono'] = $user['telefono'];

            header("Location: index.php");
            exit;
        } else {
            header("Location: login.php?error=Credenciales incorrectas");
            exit;
        }
    } else {
        header("Location: login.php?error=Faltan campos");
        exit;
    }
}
