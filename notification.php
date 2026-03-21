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
    <title>notification</title>
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

    
    <!-- Section Notifications -->
    <section id="dashboard-section" class="page" >
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Notifications</h3>
            </div>
            <div style="max-height: 400px; ">
                <div style="padding: 16px; border-bottom: 1px solid #9db6ce;">
                    <p><strong>Nouveau rendez-vous</strong> - M. Martin à 14:30 aujourd'hui</p>
                    <small style="color: #1d1f20;">Il y a 10 minutes</small>
                </div>
                <div style="padding: 16px; border-bottom: 1px solid #e9ecef;">
                    <p><strong>Rappel</strong> - Formation continue le 15/11/2023</p>
                    <small style="color: #1d1f20;">Hier</small>
                </div>
                <div style="padding: 16px; border-bottom: 1px solid #e9ecef;">
                    <p><strong>Annulation</strong> - Mme. Dubois a annulé son rendez-vous</p>
                    <small style="color: #1d1f20;">Il y a 2 jours</small>
                </div>
                <div style="padding: 16px; border-bottom: 1px solid #e9ecef;">
                    <p><strong>Nouveau message</strong> - Vous avez reçu un message d'un Naturopathe</p>
                    <small style="color: #1d1f20;">Il y a 3 jours</small>
                </div>
            </div>
        </div>
    </section>






    <!-- Pied de page (commun à toutes les pages) -->
    <?php include('includes/footer.php') ?>



    <script src="assets/js/eco_sante.js"></script>
</body>

</html>