<?php
require_once __DIR__ . '/config/database.php';
$db = getDBConnection();
$stmt = $db->prepare("SELECT video_zip FROM courses WHERE id = 5");
$stmt->execute();
$course = $stmt->fetch();
echo "Raw video_zip: " . $course['video_zip'] . PHP_EOL;
?>
