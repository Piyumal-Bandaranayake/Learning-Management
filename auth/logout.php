<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session cookie if it exists
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy terminal session
session_destroy();

// Redirect to home/login
header("Location: /Learning-Mangment/index.php");
exit;
?>
