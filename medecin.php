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

$medecins= $userdb->readRole('medecin');

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spécialiste</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="assets/css/medecin.css">
    <link rel="stylesheet" href="assets/css/eco_sante.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <!-- Navigation principale (commune à toutes les pages) -->
    <!-- Header -->
    <!-- Header -->
    <header>
        <div class="container">
            <?php include('includes/header.php') ?>
        </div>
    </header>
    <section id="dashboard-page" class="page">
        <?php include('includes/header2.php') ?>
    </section>






    <!-- Page spécialistes  -->

    <main class="container">
        <div class="search-bar-container">
            <input type="text" name="search" id="specialist-search" placeholder="Rechercher un spécialiste...">
        </div>
            <section id="specialist-list">
                    <?php 
                    if($medecins != null && sizeof($medecins) > 0):
                        foreach($medecins as $medecin):
                    ?>  

                    <div class="specialist-block">
                        <div class="specialist-info">
                            <?php 
                                if($medecin->photo != null && $medecin->photo != '') {
                                    echo '<img src="'. BACKEND_PATH_USER_PHOTO . $medecin->photo .'" alt="">';
                                }
                                else {
                                    echo '<img src="'. BACKEND_PATH_USER_PHOTO . 'user.png' .'" alt="">';
                                }
                            ?>

                            <div class="details">
                                <h3>
                                        DR. 
                                        <?= $medecin->prenom ?>
                                        <?= $medecin->nom ?>
                                </h3>
                                <p class="specialty" style="color:red">
                                    <?= $medecin->specialite ?>
                                </p>
                            </div>
                        </div>
                        <div class="planning-info">
                            <p>
                                <strong>Planning :</strong>
                                Lundi, Mercredi, Vendredi
                            </p>
                            <p>
                                <strong>Crénaux :</strong>
                                09:00, 11:00, 14:30
                            </p>
                        </div>
                        <div class="rdv-action">
                            <button class="btn btn-danger btn-md" data-bs-toggle="modal" data-bs-target="#formModal"
                                onclick="editForm(<?= $medecin->iduser ?>)">
                                <!-- <i class="fas fa-plus me-1"></i>  -->
                                Prendre un rendez-vous
                            </button>
                               <button class="btn btn-success btn-md" >
                                <!-- <i class="fas fa-plus me-1"></i>  -->
                                Effectuer un Paiement
                            </button>
                            <button class="btn btn-primary btn-md" >
                                <!-- <i class="fas fa-plus me-1"></i>  -->
                               <a href="meet.php" style="color:white;text-decoration-line:none;">Debuter la Consultation</a> 
                            </button>
                        </div>
                    </div>

                    <script type="text/javascript">
                        function editForm(id) {
                            document.querySelector("#idmedecin").value= id;
                        }
                    </script>

                    <?php
                        endforeach;
                    endif;
                    ?>
                </section>
    </main>



    <div class="modal fade" id="formModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Informations sur le rendez-vous</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="form_edit" id="form_edit" method="POST" action="#" enctype="multipart/form-data">

                        <input type="hidden" name="iduser" id="iduser" value="<?= $profil->iduser ?>" />

                        <input type="hidden" name="idmedecin" id="idmedecin" />


                        <div class="form-group">
                            <label for="rdv-motif">Motif du rendez-vous</label>
                            <input type="text" name="motif" id="rdv-motif" required>
                        </div>

                        <div class="form-group">
                            <label for="rdv-hours">Durée</label>
                           <input type="time" id="rdv-hours" placeholder="09:00 - 12:00, 14:00 - 18:00" name="duree" required>
                        </div>

                        <div class="form-group">
                            <label for="rdv-date">Date et heure</label>
                            <input type="datetime-local" name="date_rdv" id="rdv-date" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Confirmer le rendez-vous
                        </button>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>







    <!-- Pied de page (commun à toutes les pages) -->
    <?php include('includes/footer.php') ?>


    <script src="assets/js/eco_sante.js"></script>
</body>

</html>