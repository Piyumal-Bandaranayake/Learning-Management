<?php
require_once '../includes/auth_check.php';
require_admin();
require_once '../config/database.php';

header('Content-Type: application/json');

$id = $_GET['id'] ?? null;
if (!$id) {
    echo json_encode(['success' => false, 'message' => 'No ID provided']);
    exit;
}

$db = getDBConnection();
try {
    $stmt = $db->prepare("SELECT id, name, email, whatsapp_number, username, created_at FROM admins WHERE id = ?");
    $stmt->execute([$id]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        echo json_encode(['success' => true, 'admin' => $admin]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Admin not found']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>
