<?php
// Gere la connexion des utilisateurs au site
$email= $_POST['email'];
$password= $_POST['password'];

$user= $userdb->readConnexion2($email, $password);

// Si les identifiants sont faux
if($user == false) {
    $_SESSION['erreur']= array(
        'type' => 'danger',
        'message' => 'Echec de connexion'
    );
    header('Location:../login.php');
}
// Si la connexion reussit on redirige selon le role
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