<?php
$email= $_POST['email'];
$password= $_POST['password'];

$user= $userdb->readConnexion2($email, $password);

if($user == false) {
    $_SESSION['erreur']= array(
        'type' => 'danger',
        'message' => 'Echec de connexion'
    );
    header('Location:../login.php');
}
else {
    $_SESSION['erreur']= array(
        'type' => 'success',
        'message' => "Bienvenue $user->nom"
    );
    $_SESSION['profil']= $user;

    if($user->role == 'admin') {
        header('Location:index.php?view=dashboard');
    }
    else if($user->role == 'medecin') {
        //header('Location:index.php?view=rdv');
        header('Location:index.php?view=dashboard');
    }
    else if($user->role == 'patient') {
        header('Location:../dashboard_patient.php');
    }
}

?>