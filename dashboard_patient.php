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
    <title>Dashboard Patient</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="assets/css/eco_sante.css">
</head>

<body>
    <!-- Navigation principale (commune à toutes les pages) -->
    <!-- Header -->
    <header>
        <div class="container">
            <?php include('includes/header.php') ?>
        </div>
    </header>
    <section id="dashboard-page" class="page">
        <?php include('includes/header2.php') ?>
    </section>

    <!-- Dashboard patient -->
    <section id="dashboard-page" class="page">
        <div class="container">
            <div class="welcome-banner">
                <h2>Bonjour, <?= $profil->nom ?> <?= $profil->prenom ?></h2>
                <p>Comment pouvons-nous vous aider aujourd'hui ?</p>
            </div>

            <div class="dashboard-cards">
                <div class="dashboard-card" data-page="specialists">
                    <h3>Spécialistes</h3>
                    <p>Prendre rendez-vous avec un spécialiste medecin ou naturophate</p>
                </div>
                <div class="dashboard-card" data-page="appointments">
                    <h3>Mes rendez-vous</h3>
                    <p>Accéder à vos rendez-vous via les notifications</p>
                </div>
                <div class="dashboard-card" data-page="consultations">
                    <h3>Consultations</h3>
                    <p>Démarrez une consultations</p>
                </div>
                <div class="dashboard-card" data-page="prescriptions">
                    <h3>Mes ordonnances</h3>
                    <p>Consulter mes ordonnances par mon dossier medical</p>
                </div>
            </div>
        </div>
    </section>






    <!-- Pied de page (commun à toutes les pages) -->
    <?php include('includes/footer.php') ?>



    <script src="assets/js/eco_sante.js"></script>
</body>

</html>