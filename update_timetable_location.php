<?php
require_once 'config/database.php';

try {
    $db = getDBConnection();
    
    // Check if column exists first to avoid error on re-run
    $stmt = $db->query("SHOW COLUMNS FROM timetable LIKE 'class_location'");
    $exists = $stmt->fetch();

    if (!$exists) {
        $db->exec("ALTER TABLE timetable ADD COLUMN class_location VARCHAR(150) NOT NULL AFTER class_time");
        echo "Column 'class_location' added successfully!";
    } else {
        echo "Column 'class_location' already exists.";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
