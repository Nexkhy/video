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

if(isset($_GET['idspecialite']) && !empty($_GET['idspecialite'])) {
    $medecins = $userdb->readSpecialite($_GET['idspecialite']);
} else {
    $medecins = $userdb->readRole('medecin');
}

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
        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'success'): ?>
            <div class="alert alert-success mt-3 mb-3">
                <i class="fas fa-check-circle me-2"></i> Votre demande de rendez-vous a été envoyée avec succès au médecin.
            </div>
        <?php endif; ?>

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
                                <?= ($medecin->planning) ? $medecin->planning : 'À définir' ?>
                            </p>
                            <p>
                                <strong>Crénaux :</strong>
                                <?= ($medecin->creneaux) ? $medecin->creneaux : 'À définir' ?>
                            </p>
                        </div>
                        <div class="rdv-action">
                            <a href="profil_medecin.php?id=<?= $medecin->iduser ?>" class="btn btn-primary btn-md w-100 mb-2">
                                <i class="fas fa-user me-1"></i> 
                                Voir le profil
                            </a>
                            <a href="profil_medecin.php?id=<?= $medecin->iduser ?>" class="btn btn-danger btn-md w-100">
                                <i class="fas fa-calendar-plus me-1"></i> 
                                Prendre un RDV
                            </a>
                            <p class="mt-2 text-muted small"><i class="fas fa-info-circle"></i> Le paiement s'effectue après validation du médecin.</p>
                        </div>

                    </div>

                    <?php
                        endforeach;
                    endif;
                    ?>
                </section>
    </main>
    
    <script type="text/javascript">
        function editForm(id) {
            document.querySelector("#idmedecin").value= id;
        }
    <script type="text/javascript">
        function editForm(id) {
            document.querySelector("#idmedecin").value= id;
        }
    </script>
    </script>



    <div class="modal fade" id="formModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Informations sur le rendez-vous</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="form_edit" id="form_edit" method="POST" action="<?= BACKEND_PATH_INDEX ?>?view=rdv.control&action=create" enctype="multipart/form-data">

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
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>








    <!-- Pied de page (commun à toutes les pages) -->
    <?php include('includes/footer.php') ?>


    <script src="assets/js/eco_sante.js"></script>
    <script>
        document.getElementById('specialist-search').addEventListener('input', function() {
            let filter = this.value.toUpperCase();
            let blocks = document.getElementsByClassName('specialist-block');
            
            for (let i = 0; i < blocks.length; i++) {
                let name = blocks[i].getElementsByTagName('h3')[0].innerText.toUpperCase();
                let specialty = blocks[i].getElementsByClassName('specialty')[0].innerText.toUpperCase();
                
                if (name.indexOf(filter) > -1 || specialty.indexOf(filter) > -1) {
                    blocks[i].style.display = "";
                } else {
                    blocks[i].style.display = "none";
                }
            }
        });
    </script>
</body>

</html>