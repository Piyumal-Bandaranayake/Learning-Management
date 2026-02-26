<?php
require_once 'config/database.php';
$db = getDBConnection();

try {
    // 1. Ensure columns exist in admins table
    $db->exec("ALTER TABLE admins ADD COLUMN IF NOT EXISTS whatsapp_number VARCHAR(20) DEFAULT NULL AFTER email");
    $db->exec("ALTER TABLE admins ADD COLUMN IF NOT EXISTS role VARCHAR(20) DEFAULT 'admin' AFTER password");
    
    // 2. Sync admins from users table NOT in admins table
    $stmt = $db->query("SELECT * FROM users WHERE role = 'admin'");
    $users = $stmt->fetchAll();
    
    foreach($users as $user) {
        $check = $db->prepare("SELECT id FROM admins WHERE username = ?");
        $check->execute([$user['username']]);
        if (!$check->fetch()) {
            $insert = $db->prepare("INSERT INTO admins (name, email, whatsapp_number, username, password, role, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $insert->execute([$user['name'], $user['email'], $user['whatsapp_number'], $user['username'], $user['password'], 'admin', $user['created_at']]);
            echo "Added admin to table: " . $user['username'] . "\n";
        } else {
            // Update whatsapp if needed
            $update = $db->prepare("UPDATE admins SET whatsapp_number = ? WHERE username = ? AND (whatsapp_number IS NULL OR whatsapp_number = '')");
            $update->execute([$user['whatsapp_number'], $user['username']]);
        }
    }
    
    echo "Synchronization complete.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
