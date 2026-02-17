<?php
require_once '../includes/auth_check.php';
require_admin();
require_once '../config/database.php';

if (isset($_GET['id'])) {
    $db = getDBConnection();
    $student_id = $_GET['id'];

    // Fetch Student Info
    $stmt = $db->prepare("SELECT id, name, email, whatsapp_number, username, created_at FROM users WHERE id = ? AND role = 'student'");
    $stmt->execute([$student_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($student) {
        // Fetch Registered Courses
        $stmt = $db->prepare("
            SELECT r.id as reg_id, r.status, r.created_at as applied_date, c.course_title, c.price, c.image 
            FROM registrations r 
            JOIN courses c ON r.course_id = c.id 
            WHERE r.user_id = ? 
            ORDER BY r.created_at DESC
        ");
        $stmt->execute([$student_id]);
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'student' => $student,
            'courses' => $courses
        ]);
        exit;
    }
}

echo json_encode(['success' => false]);
?>
