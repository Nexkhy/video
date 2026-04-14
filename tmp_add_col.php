<?php
require_once 'admin2/model/Database.php';
$db = new Database();
try {
    $db->prepare("ALTER TABLE consultation ADD COLUMN video_link VARCHAR(255) DEFAULT NULL", []);
    echo "colorne video ajouter.\n";
} catch (Exception $e) {
    echo "Notice: " . $e->getMessage() . "\n";
}
?>
