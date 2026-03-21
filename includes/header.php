<div class="header-content">
    <div class="logo">
        <a href="login.php"><i class="fas fa-heartbeat"></i></a> 
        <h1>Eco-Santé</h1>
    </div>

    <nav class="register">
        <div class="header-content">
            <ul class="parent-bar-register">
                <div class="bar-register">
                    <a href="dashboard_patient.php"  id="nav-accueil" class="nav-link ">
                        <i class="fas fa-home"></i>
                        Accueil
                    </a>

                    <a href="consult.php" class="nav-link">
                        <i class="fas fa-stethoscope"></i>Consultation
                    </a>
                    <a href="notification.php" class="nav-link">
                        <i class="fas fa-bell"></i>notifications
                    </a>
                    <a href="profil.php" class="nav-link">
                        <i class="fas fa-cog me-2"></i>
                        Paramètres
                    </a>
                </div>
            </ul>
            <div class="profil">
                <a href="<?= BACKEND_PATH_INDEX . '?view=logout' ?>" id="show-login">
                    Déconnexion
                </a>
            </div>
            <div class="profil">
                <?php 
                    if($profil->photo != null && $profil->photo != '') {
                        echo '<img src="'. BACKEND_PATH_USER_PHOTO . $profil->photo .'" style="width:50px;" alt="">';
                    }
                    else {
                        echo '<img src="'. BACKEND_PATH_USER_PHOTO . 'user.png' .'" style="width:50px;" alt="">';
                    }
                ?>

                <h3>
                    <?= $profil->nom ?>
                    <?= $profil->prenom ?>
                </h3>
            </div>
        </div>
        
        <span><i class="fa-solid fa-bars fa-2x icon-bar-register"></i></span>
    </nav>
</div>