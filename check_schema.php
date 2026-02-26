<?php
require_once 'config/database.php';
$db = getDBConnection();
$stmt = $db->query("DESCRIBE admins");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "Admins Table Structure:\n";
foreach($columns as $col) {
    echo "- " . $col['Field'] . " (" . $col['Type'] . ")\n";
}

$stmt = $db->query("DESCRIBE users");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "\nUsers Table Structure:\n";
foreach($columns as $col) {
    echo "- " . $col['Field'] . " (" . $col['Type'] . ")\n";
}
?>
