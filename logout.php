<?php
session_start();

// Borrar todas las variables de sesión
$_SESSION = [];

// Destruir la sesión
session_unset();
session_destroy();

// Borrar cookie si está configurada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirigir al login
header("Location: login.php");
exit();
