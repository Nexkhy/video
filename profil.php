<?php 
require_once 'config.php'; 
include(BACKEND_PATH_ERREUR);
$profil= null;
if(isset($_SESSION['profil']) == true) {
    $profil= $_SESSION['profil'];
}
else {
    header('Location:login.php');
}



?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon profil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="assets/css/eco_sante.css">
</head>
<body>
   
           <!-- Header -->
  <header>
        <div class="container">
            <?php include('includes/header.php') ?>
        </div>
    </header>
        <!-- Page profil (cachée par défaut) -->
        <section id="profile-page" class="page" >
            <div class="container">
                <div class="profile-container">
                    <div class="profile-header">
                        <div class="profile-avatar">JD</div>
                        <div class="profile-info">
                            <h2>Profil utilisateur</h2>
                            <p>Gérez vos informations personnelles</p>
                        </div>
                    </div>

                    <form id="profile-form">
                        <div class="profile-form">
                            <div class="form-group">
                                <label for="profile-name">Nom complet</label>
                                <input type="text" id="profile-name" value="jahsauve yimele" >
                            </div>
                            <div class="form-group">
                                <label for="profile-email">Email</label>
                                <input type="email" id="profile-email" value="jahsauve@example.com" >
                            </div>
                            <div class="form-group">
                                <label for="profile-phone">Téléphone</label>
                                <input type="tel" id="profile-phone" value="698308780" >
                            </div>
                            <div class="form-group">
                                <label for="profile-role">Rôle</label>
                                <input type="text" id="profile-role" value="Patient" >
                            </div>
                            <div class="form-group">
                                <label for="profile-password">Mot de passe</label>
                                <input type="password" id="profile-password" value="" >
                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn-primary" id="edit-profile">Modifier</button>
                                <button type="submit" class="btn-secondary" id="save-profile" disabled>Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>






    <!-- Pied de page (commun à toutes les pages) -->
    <?php include('includes/footer.php') ?>



    <script src="assets/js/eco_sante.js"></script>
</body>
</html>