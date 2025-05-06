<?php

// jean recorda algo esta cosa tiene una medidad de seguridad llamada hash que cifra la contraseña dentro del sistema para mas seguridad
// a la hora de crear el "crear_usuario" tienes que ponerle para que te cifre la contraseña con "$password_hash()" asi te la cifra  
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
        // Consulta con el nuevo campo 'rol'
        $stmt = $pdo->prepare("SELECT id_usuario, usuario, contrasena, rol FROM usuarios WHERE BINARY usuario = :usuario");
        $stmt->execute(['usuario' => $usuario]);
        $usuarioData = $stmt->fetch();

        if ($usuarioData) {
            if (password_verify($contrasena, $usuarioData['contrasena'])) {
                // Guardar en sesión
                $_SESSION["id_usuario"] = $usuarioData["id_usuario"];
                $_SESSION["usuario"] = $usuarioData["usuario"];
                $_SESSION["rol"] = $usuarioData["rol"]; // guardar rol

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
