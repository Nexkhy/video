<?php 
if(session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'model/AvisDB.php';
require_once 'model/ConsultationDB.php';
require_once 'model/ExamenDB.php';
require_once 'model/MedicamentDB.php';
require_once 'model/ModeDB.php';
require_once 'model/NotificationDB.php';
require_once 'model/PaiementDB.php';
require_once 'model/PlanningDB.php';
require_once 'model/RdvDB.php';
require_once 'model/SpecialiteDB.php';
require_once 'model/SuivieDB.php';
require_once 'model/UserDB.php';

require_once 'tools/Package.php';
require_once 'tools/Upload.php';
require_once 'tools/Mailer.php';

$avisdb = new PlanningDB();
$consultationdb = new ConsultationDB();
$examendb = new ExamenDB();
$medicamentdb = new MedicamentDB();
$modedb = new ModeDB();
$notificationdb = new NotificationDB();
$paiementdb = new PaiementDB();
$planningdb = new PlanningDB();
$rdvdb = new RdvDB();
$specialitedb = new SpecialiteDB();
$suiviedb = new SuivieDB();
$userdb = new UserDB();

$package = new Package();
$upload = new Upload();
$mailer = new Mailer();

define('RES_USER_PHOTO', array(
    "path" => 'ressources/user/',
    "width_max" => 300,
    "height_max" => 300,
    "prefix_name" => "user"
));

define('RES_CONSULTATION_DOC', array(
    "path" => 'ressources/consultation/',
    "prefix_name" => "doc"
));

define('RES_SUIVIE_DOC', array(
    "path" => 'ressources/suivie/',
    "prefix_name" => "doc"
));
?>