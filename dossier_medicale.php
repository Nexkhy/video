<?php 
require_once 'config.php'; 
require_once BACKEND_PATH_SERVICE; 

$profil= null;
if(isset($_SESSION['profil']) == true) {
    $profil= $_SESSION['profil'];
}
else {
    header('Location:login.php');
}

include(BACKEND_PATH_ERREUR);
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ordonnances</title>
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




    <!-- Page ordonnances -->
    <section id="prescriptions-page" class="page">
        <div class="container">
            <h2>Mes ordonnances</h2>

            <div class="prescriptions-list" id="prescriptions-container">
                <!-- Les ordonnances seront ajoutées ici dynamiquement -->
            </div>
        </div>
    </section>





    <!-- Pied de page (commun à toutes les pages) -->
    <?php include('includes/footer.php') ?>

    <script src="assets/js/eco_sante.js"></script>
</body>

</html>