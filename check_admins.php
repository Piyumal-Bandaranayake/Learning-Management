<?php
require_once 'config/database.php';
$db = getDBConnection();
$stmt = $db->query("SELECT COUNT(*) as count FROM admins");
$count = $stmt->fetchColumn();
echo "Total Admins: " . $count . "\n";

$stmt = $db->query("SELECT name, username, email FROM admins");
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($admins as $admin) {
    echo "- " . $admin['name'] . " (@" . $admin['username'] . ") | " . $admin['email'] . "\n";
}
?>
