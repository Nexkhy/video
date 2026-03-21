<?php 
require_once 'config.php'; 
include(BACKEND_PATH_ERREUR);
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> -->
    <link rel="stylesheet" href="./assets/fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/eco_sante.css">
    <script src="./assets/js/eco_sante.js" defer></script>

</head>

<body>
    <!-- Navigation principale (commune à toutes les pages) -->
    <!-- Header -->
    <header>
        <div class="container register">
            <div class="header-content">
                <div class="logo">
                    <a href="index.php"><i class="fas fa-heartbeat"></i></a>
                    <h1>Eco_santé</h1>
                </div>
                <nav class="parent-bar-register">
                    <ul class="bar-register">
                        <li>
                            <a href="index.php" class="active" id="nav-accueil">
                                Accueil
                            </a>
                        </li>
                        
                        <li>
                            <a href="login.php" class="btn" id="btn-login">
                                Se connecter
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <span><i class="fa-solid fa-bars fa-2x icon-bar-register"></i></span>
        </div>
    </header>




    <!-- Page d'inscription -->
    <section id="signup-page" class="page">
        <div class="container form-container">
            <form class="auth-container" id="register-form" enctype="multipart/form-data" action="<?= BACKEND_PATH_INDEX ?>?view=user.control?action=create_patient" method="POST">
                <div class="auth-form">
                    <h2>Inscription</h2>
                    <div class="form-group">
                        <label for="fullname">Nom </label>
                        <input  type="text"name="nom"  id="fullname" placeholder="Votre nom " required>
                        <div class="error" id="NameError"></div>
                    </div>

                    <div class="form-group">
                        <label for="fullname">Prenom </label>
                        <input  type="text"name="prenom"  id="fullname" placeholder="Votre Prenom" required>
                        <div class="error" id="NameError"></div>
                    </div>

                    <div class="form-group">
                        <label for="fullname">Sexe </label>
                        <input  type="text"name="Sexe"  id="fullname" placeholder="Votre Sexe" required>
                        <div class="error" id="NameError"></div>
                    </div>
                    <div class="form-group">
                        <label for="register-email">Email</label>
                        <input type="email" name="email" id="register-email" placeholder="Votre adresse email" required>
                        <div class="error" id="loginEmailError"></div>
                    </div>
                    <div class="form-group">
                        <label for="register-password">Mot de passe</label>
                        <input type="password" name="password" id="register-password" placeholder="Créez un mot de passe" required>
                        <div class="error" id="passwordError"></div>
                    </div>
                
                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="tel" name="tel" id="phone" placeholder="Votre numéro de téléphone" required>
                        <div class="error" id="TelError"></div>
                    </div>

                    <div class="form-group">
                        <label for="phone">Role</label>
                        <select name="role" id="">
                            <option value="patient">Patient</option>
                            <option value="admin">Admin</option>
                        </select>
                        <div class="error" id="TelError"></div>
                    </div>
                    <div class="form-group">
                        <label for="phone">Entrer votre photo</label>
                        <input type="file" name="photo" id="phone" placeholder="Votre numéro de téléphone" required>
                        <div class="error" id="TelError"></div>
                    </div>
                    <button class="btn" style="width: 100%;" id="register-btn" type="submit">
                        <i class="fas fa-user-plus"></i> <span id="register-text">S'inscrire</span>
                    </button>
                    <p style="text-align: center; margin-top: 24px;">
                        Déjà inscrit ? <a href="./login.php" id="show-login">Se connecter</a>
                    </p>
                </div>
            </form>
        </div>
    </section>

</body>

</html>