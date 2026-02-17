<?php
require_once '../config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = getDBConnection();
    
    $login_input = trim($_POST['username'] ?? ''); // Can be email or username
    $password = $_POST['password'] ?? '';

    if (empty($login_input) || empty($password)) {
        $_SESSION['login_error'] = "Please enter both username/email and password.";
        header("Location: ../login.php");
        exit;
    }

    try {
        // 1. First, check the 'admins' table
        $stmt = $db->prepare("SELECT *, 'admin' as derived_role FROM admins WHERE email = ? OR username = ? LIMIT 1");
        $stmt->execute([$login_input, $login_input]);
        $identity = $stmt->fetch();

        // 2. If not found in admins, check the 'users' table
        if (!$identity) {
            $stmt = $db->prepare("SELECT *, role as derived_role FROM users WHERE email = ? OR username = ? LIMIT 1");
            $stmt->execute([$login_input, $login_input]);
            $identity = $stmt->fetch();
        }

        if ($identity && password_verify($password, $identity['password'])) {
            // Success: Set Sessions
            session_regenerate_id(true);
            
            $_SESSION['user_id'] = $identity['id'];
            $_SESSION['name'] = $identity['name'];
            $_SESSION['email'] = $identity['email'];
            $_SESSION['whatsapp'] = $identity['whatsapp_number'] ?? '';
            $_SESSION['username'] = $identity['username'];
            $_SESSION['role'] = $identity['derived_role'];

            // Redirect based on role
            if ($_SESSION['role'] === 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../student/dashboard.php");
            }
            exit;
        } else {
            $_SESSION['login_error'] = "Invalid username or password.";
            header("Location: ../login.php");
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['login_error'] = "An error occurred. Please try again later.";
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
