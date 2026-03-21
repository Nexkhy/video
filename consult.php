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
    <title>Consultation</title>
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
            <!-- Page consultation (cachée par défaut) -->
        <section id="consultations-page" class="page" >
            <div class="container">
                <h2>Consultation en cours</h2>
                
                <div class="consultation-container">
                    <div class="video-container">
                        <div class="video-placeholder">
                            Zone de vidéoconférence
                        </div>
                    </div>

                    <div class="chat-container">
                        <div class="chat-messages" id="chat-messages">
                            <!-- Les messages de chat seront ajoutés ici dynamiquement -->
                        </div>

                        <div class="chat-actions">
                            <div class="file-upload">
                                <h3>Fichiers</h3>
                                <input type="file" id="file-upload">
                                <button class="btn-primary">Envoyer</button>
                            </div>

                            <div class="notes-section">
                                <h3>Notes</h3>
                                <textarea placeholder="Prenez des notes pendant la consultation..."></textarea>
                                <button class="btn-primary">Sauvegarder</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>






    <!-- Pied de page (commun à toutes les pages) -->
    <?php include('includes/footer.php') ?>



    <script src="assets/js/eco_sante.js"></script>
</body>
</html>