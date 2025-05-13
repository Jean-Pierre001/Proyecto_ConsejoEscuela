<?php
session_start();
require_once 'baseDatos/conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"]);
    $contrasena = trim($_POST["contrasena"]);

    if (empty($usuario) || empty($contrasena)) {
        echo "⚠️ Por favor complete ambos campos.";
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT id_usuario, nombre, contrasena, tipo FROM usuarios WHERE BINARY nombre = :usuario");
        $stmt->execute(['usuario' => $usuario]);
        $usuarioData = $stmt->fetch();

        if ($usuarioData) {
            if (password_verify($contrasena, $usuarioData['contrasena'])) {
                // Guardar en sesión
                $_SESSION["id_usuario"] = $usuarioData["id_usuario"];
                $_SESSION["usuario"] = $usuarioData["nombre"];
                $_SESSION["rol"] = $usuarioData["tipo"]; // guardar tipo como rol

                // Redirigir al inicio
                header("Location: index.php");
                exit;
            } else {
                echo "❌ Contraseña incorrecta.";
            }
        } else {
            echo "❌ Usuario no encontrado.";
        }

    } catch (PDOException $e) {
        echo "🚨 Error en la base de datos: " . $e->getMessage();
    }
} else {
    echo "🚫 Acceso no permitido.";
}
?>
