<div class="header-content">
    <div class="logo">
        <a href="login.php"><i class="fas fa-heartbeat"></i></a> 
        <h1>Eco-Santé</h1>
    </div>

    <nav class="register">
        <ul class="parent-bar-register">
            <li class="bar-register">
                <a href="dashboard_patient.php" id="nav-accueil" class="nav-link">
                    <i class="fas fa-home"></i> Accueil
                </a>
                <a href="consult.php" class="nav-link">
                    <i class="fas fa-stethoscope"></i> Consultation
                </a>
                <a href="notification.php" class="nav-link">
                    <i class="fas fa-bell"></i> Notifications
                </a>
                <a href="profil.php" class="nav-link">
                    <i class="fas fa-cog"></i> Paramètres
                </a>
            </li>
        </ul>

        <div class="header-profile">
            <div class="header-avatar-info">
                <?php 
                    $photo = ($profil->photo != null && $profil->photo != '') ? $profil->photo : 'user.png';
                ?>
                <img src="<?= BACKEND_PATH_USER_PHOTO . $photo ?>" alt="Profile">
                <div class="profile-text">
                    <span class="user-name"><?= $profil->nom ?> <?= $profil->prenom ?></span>
                    <a href="<?= BACKEND_PATH_INDEX . '?view=logout' ?>" class="logout-link">Déconnexion</a>
                </div>
            </div>
        </div>
        
        <div class="menu-toggle-btn">
            <i class="fa-solid fa-bars fa-2x icon-bar-register"></i>
        </div>
    </nav>
</div>