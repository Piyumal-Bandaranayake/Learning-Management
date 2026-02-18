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

    if (empty($_POST['terms'])) {
        $errors[] = "You must agree to the Terms and Conditions.";
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
        // Check Email
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "The email address '$email' is already registered. Please use a different email.";
        }

        // Check Username
        $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $errors[] = "The username '$username' is already taken. Please choose another one.";
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
