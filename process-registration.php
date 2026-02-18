<?php
require_once 'includes/auth_check.php';
require_login();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = getDBConnection();
    
    $user_id = $_SESSION['user_id'];
    $course_id = $_POST['course_id'] ?? 0;
    $phone = trim($_POST['phone'] ?? '');
    
    // Basic validation
    if (empty($course_id) || empty($phone)) {
        die("Missing required information.");
    }

    if (!isset($_POST['terms'])) {
        die("You must agree to the Terms & Conditions to register.");
    }

    // Check if Course exists
    $stmt = $db->prepare("SELECT id FROM courses WHERE id = ?");
    $stmt->execute([$course_id]);
    if (!$stmt->fetch()) {
        die("Invalid Course.");
    }

    // Handle Receipt Upload
    $receipt_path = '';
    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
        $file_type = $_FILES['receipt']['type'];
        $file_size = $_FILES['receipt']['size'];
        
        if (!in_array($file_type, $allowed_types)) {
            die("Only JPG, PNG, and PDF receipts are allowed.");
        }
        
        if ($file_size > 5 * 1024 * 1024) { // 5MB
            die("Receipt file is too large (max 5MB).");
        }

        $extension = pathinfo($_FILES['receipt']['name'], PATHINFO_EXTENSION);
        $filename = 'receipt_' . $user_id . '_' . $course_id . '_' . time() . '.' . $extension;
        $upload_dir = 'uploads/receipts/';
        
        if (!move_uploaded_file($_FILES['receipt']['tmp_name'], $upload_dir . $filename)) {
            die("Failed to upload receipt.");
        }
        $receipt_path = $upload_dir . $filename;
    } else {
        die("Payment receipt is required.");
    }

    // Save Registration
    try {
        // Prevent duplicate pending/approved registrations
        $stmt = $db->prepare("SELECT id FROM registrations WHERE user_id = ? AND course_id = ? AND status IN ('pending', 'approved')");
        $stmt->execute([$user_id, $course_id]);
        if ($stmt->fetch()) {
            die("You have already registered for this Course (Request is pending or approved).");
        }

        $stmt = $db->prepare("INSERT INTO registrations (user_id, course_id, phone, payment_receipt) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $course_id, $phone, $receipt_path]);
        
        // Success
        header("Location: my-registrations.php?success=1");
        exit;
        
    } catch (PDOException $e) {
        die("Registration error: " . $e->getMessage());
    }
} else {
    header("Location: courses.php");
    exit;
}
?>
