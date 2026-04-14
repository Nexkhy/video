<?php
require_once 'config.php';
require_once 'admin2/model/Database.php';

$db = new Database();

echo "=== MEDECINS ===\n";
$req = $db->prepare("SELECT iduser, nom, prenom, role, solde, taux FROM user WHERE role='medecin'");
$medecins = $db->getDatas($req, false);
print_r($medecins);

echo "\n=== ADMINS ===\n";
$req = $db->prepare("SELECT iduser, nom, prenom, role, solde, taux FROM user WHERE role='admin'");
$admins = $db->getDatas($req, false);
print_r($admins);

echo "\n=== CONSULTATIONS RENTES ===\n";
$req = $db->prepare("SELECT idconsultation, idmedecin, iduser as idpatient, reference, montant, statut, date_consultation FROM consultation ORDER BY idconsultation DESC LIMIT 5");
$consultations = $db->getDatas($req, false);
print_r($consultations);
?>
