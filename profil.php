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
                        <div class="profile-avatar">
                            <?= strtoupper(substr($profil->nom, 0, 1) . substr($profil->prenom, 0, 1)) ?>
                        </div>
                        <div class="profile-info">
                            <h2>Profil utilisateur</h2>
                            <p>Gérez vos informations personnelles</p>
                        </div>
                    </div>

                    <form id="profile-form" method="POST" action="<?= BACKEND_PATH_INDEX ?>?view=user.control&action=update">
                        <input type="hidden" name="iduser" value="<?= $profil->iduser ?>">
                        <input type="hidden" name="idspecialite" value="<?= $profil->idspecialite ?? '' ?>">
                        <input type="hidden" name="from_profil" value="1">
                        
                        <div class="profile-form">
                            <div class="form-group">
                                <label for="profile-nom">Nom</label>
                                <input type="text" name="nom" id="profile-nom" value="<?= htmlspecialchars($profil->nom ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="profile-prenom">Prénom</label>
                                <input type="text" name="prenom" id="profile-prenom" value="<?= htmlspecialchars($profil->prenom ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="profile-sexe">Sexe</label>
                                <select name="sexe" id="profile-sexe" required>
                                    <option value="M" <?= ($profil->sexe == 'M') ? 'selected' : '' ?>>Masculin</option>
                                    <option value="F" <?= ($profil->sexe == 'F') ? 'selected' : '' ?>>Féminin</option>
                                </select>
                            </div>
                            <div class="form-group" style="grid-column: span 2;">
                                <label for="profile-adresse">Adresse</label>
                                <textarea name="adresse" id="profile-adresse" rows="3" required><?= htmlspecialchars($profil->adresse ?? '') ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="profile-email">Email</label>
                                <input type="email" name="email" id="profile-email" value="<?= htmlspecialchars($profil->email ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="profile-phone">Téléphone</label>
                                <input type="tel" name="telephone" id="profile-phone" value="<?= htmlspecialchars($profil->telephone ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="profile-role">Rôle</label>
                                <input type="text" name="role" id="profile-role" value="<?= htmlspecialchars($profil->role ?? '') ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="profile-password">Nouveau mot de passe</label>
                                <input type="password" name="password" id="profile-password" placeholder="Laissez vide pour ne pas modifier">
                            </div>
                            <div class="form-actions" style="grid-column: span 2;">
                                <button type="submit" class="btn-primary" id="save-profile" style="width:100%;">Enregistrer les modifications</button>
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