<?php 
// Page d'authentification pour accéder aux espaces sécurisés
require_once 'config.php'; 
include(BACKEND_PATH_ERREUR);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECO-SANTE | Connexion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./assets/fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/eco_sante.css">
</head>
 
<body>
    <!-- Navigation principale (commune à toutes les pages) -->
    <header style="background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
        <div class="container">
            <div class="header-content" style="height: 56px;">
                <div class="logo" style="display:flex; align-items:center; gap:8px;">
                    <a href="index.php" style="color:var(--primary-color); font-size:1.2rem;"><i class="fas fa-heartbeat"></i></a>
                    <h1 style="color:var(--primary-color); font-size:1.2rem; margin:0; line-height:1;">Eco-Santé</h1>
                </div>
                <nav style="display:flex; align-items:center; gap:15px;">
                    <a href="index.php" class="nav-link">Accueil</a>
                    <a href="register.php" class="nav-link btn" style="padding:6px 14px; background:var(--primary-color); color:white; border-radius:20px;">Créer un compte</a>
                </nav>
            </div>
        </div>
    </header>






    <!-- Page de connexion (cachée par défaut) -->
    <form class="auth-container" id="login-form" method="POST" action="<?= BACKEND_PATH_INDEX ?>?view=signin">
        <div class="auth-form">
            <h2>Connexion</h2>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Votre adresse email" required>
                <div class="error" id="loginEmailError"></div>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" placeholder="Votre mot de passe" required>
                <div class="error" id="loginPasswordError"></div>
            </div>
            <div class="form-options">
                <label>
                    <input type="checkbox" id="remember-me"> Se souvenir de moi
                </label>
                <a href="#" id="forgot-password">Mot de passe oublié ?</a>
            </div>
            <button class="btn" style="width: 100%;" id="login-btn" type="submit">
                <i class="fas fa-sign-in-alt"></i> <span id="login-text">Se connecter</span>
            </button>
            <p style="text-align: center; margin-top: 24px;">
                Pas encore inscrit ? <a href="./register.php" id="show-login">Créer un compte</a>
            </p>
        </div>
    </form>





    <!-- Pied de page (commun à toutes les pages) -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Eco_santé</h3>
                    <p>Plateforme de téléconsultation médicale</p>
                </div>
                <div class="footer-section">
                    <h3>Liens rapides</h3>
                    <a href="#" id="footer-accueil">Accueil</a>
                    <a href="#about" id="footer-about">À propos</a>
                    <a href="#">Mentions légales</a>
                    <a href="#">Politique de confidentialité</a>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p>contact@Eco_santé.fr</p>
                    <p>+33 1 23 45 67 89</p>
                    <p>123 Rue de la Santé, Douala</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 Eco_santé. Tous droits réservés.</p>
            </div>
        </div>
    </footer>






    <script src="./assets/js/eco_sante.js"></script>
</body>

</html>