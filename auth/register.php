<?php
require_once '../config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = getDBConnection();
    
    // Collect and sanitize input
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $whatsapp = trim($_POST['whatsapp_number'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    $errors = [];

    // Validation
    if (empty($name) || empty($email) || empty($whatsapp) || empty($username) || empty($password)) {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (!preg_match('/^[0-9]+$/', $whatsapp)) {
        $errors[] = "WhatsApp number must be numeric.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Check uniqueness (Email and Username)
    if (empty($errors)) {
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$email, $username]);
        if ($stmt->fetch()) {
            $errors[] = "Email or Username already exists.";
        }
    }

    // Process Registration
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        try {
            $stmt = $db->prepare("INSERT INTO users (name, email, whatsapp_number, username, password, role) VALUES (?, ?, ?, ?, ?, 'student')");
            $stmt->execute([$name, $email, $whatsapp, $username, $hashed_password]);
            
            $_SESSION['success_msg'] = "Registration successful! You can now login.";
            header("Location: ../login.php");
            exit;
        } catch (PDOException $e) {
            $errors[] = "Registration failed. Please try again later.";
        }
    }

    // Return with errors
    if (!empty($errors)) {
        $_SESSION['register_errors'] = $errors;
        $_SESSION['form_data'] = $_POST; // Keep data for refilling
        header("Location: ../register.php");
        exit;
    }
} else {
    header("Location: ../register.php");
    exit;
}
?>
