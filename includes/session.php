<?php
// Configurar opciones seguras de sesión
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);

session_start();

// Tiempo de inactividad permitido (en segundos)
define('SESSION_TIMEOUT', 900); // 15 minutos

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Verificar IP y navegador (protección contra hijacking)
if (!isset($_SESSION['ip_address']) || !isset($_SESSION['user_agent'])) {
    // Guardar los datos en la primera carga
    $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
} else {
    // Comparar con los datos actuales
    if ($_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR'] ||
        $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}

// Verificar tiempo de inactividad
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
    session_unset();
    session_destroy();
    header("Location: login.php?timeout=1");
    exit();
}

// Actualizar el tiempo de actividad
$_SESSION['last_activity'] = time();
