<?php
$user= $_SESSION['profil'];
session_unset();
$_SESSION['erreur']= array(
    'type' => 'success',
    'message' => "Au revoir $user->nom !!! Merci d'avoir utilisé notre plateforme."
);
header('Location:../login.php');
?>