<?php
session_start();
$_SESSION['erreur'] = "Le paiement a été annulé.";
header('Location: medecin.php');
exit();
