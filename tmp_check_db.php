<?php
require_once 'admin2/model/Database.php';
$db = new Database();
$req = $db->prepare("DESCRIBE consultation", []);
$results = $db->getDatas($req, false);
foreach ($results as $row) {
    echo $row->Field . " - " . $row->Type . "\n";
}
?>
