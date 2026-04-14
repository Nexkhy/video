<?php 
// Cette page affiche le formulaire d'inscription pour les nouveaux patients
require_once 'config.php'; 
require_once BACKEND_PATH_SERVICE;
include(BACKEND_PATH_ERREUR);

// Si quelqu'un est déjà connecté (médecin, admin ou patient), on le redirige vers son tableau de bord
if (isset($_SESSION['profil'])) {
    $role = $_SESSION['profil']->role ?? 'patient';
    if ($role === 'medecin' || $role === 'admin') {
        header('Location: ' . BACKEND_PATH_INDEX);
    } else {
        header('Location: dashboard_patient.php');
    }
    exit;
}

// On charge la liste de toutes les spécialités médicales disponibles (par exemple pour l'affichage)
$specialites = $specialitedb->readAll();
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
    <style>
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .form-grid .full-width {
            grid-column: 1 / -1;
        }
        .form-grid .form-group {
            margin-bottom: 0;
        }
        @media (max-width: 600px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
        .auth-form {
            max-width: 600px !important;
            width: 100%;
        }
    </style>
</head>

<body>
    <!-- Navigation principale -->
    <header style="background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
        <div class="container">
            <div class="header-content" style="height: 56px;">
                <div class="logo" style="display:flex; align-items:center; gap:8px;">
                    <a href="index.php" style="color:var(--primary-color); font-size:1.2rem;"><i class="fas fa-heartbeat"></i></a>
                    <h1 style="color:var(--primary-color); font-size:1.2rem; margin:0; line-height:1;">Eco-Santé</h1>
                </div>
                <nav style="display:flex; align-items:center; gap:15px;">
                    <a href="index.php" class="nav-link">Accueil</a>
                    <a href="login.php" class="nav-link btn" style="padding:6px 14px; background:var(--primary-color); color:white; border-radius:20px;">Se connecter</a>
                </nav>
            </div>
        </div>
    </header>




    <!-- Page d'inscription -->
    <section id="signup-page" class="page">
        <div class="container form-container">
            <form class="auth-container" id="register-form" enctype="multipart/form-data" action="<?= BACKEND_PATH_INDEX ?>?view=user.control&action=create" method="POST">
                <div class="auth-form">
                    <h2>Inscription</h2>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="fullname">Nom</label>
                            <input type="text" name="nom" id="fullname" placeholder="Votre nom" required>
                            <div class="error" id="NameError"></div>
                        </div>

                        <div class="form-group">
                            <label for="prenom">Prénom</label>
                            <input type="text" name="prenom" id="prenom" placeholder="Votre prénom" required>
                            <div class="error" id="NameError"></div>
                        </div>

                        <div class="form-group">
                            <label for="sexe">Sexe</label>
                            <select name="sexe" id="sexe" required style="width: 100%; padding: 16px; border: 2px solid var(--gray-light); border-radius: var(--border-radius); font-size: 1rem; transition: var(--transition);">
                                <option value="">Choisir</option>
                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                            <div class="error" id="NameError"></div>
                        </div>

                        <div class="form-group">
                            <label for="phone">Téléphone</label>
                            <input type="tel" name="telephone" id="phone" placeholder="Numéro de téléphone" required>
                            <div class="error" id="TelError"></div>
                        </div>

                        <div class="form-group full-width">
                            <label for="register-email">Email</label>
                            <input type="email" name="email" id="register-email" placeholder="Votre adresse email" required>
                            <div class="error" id="loginEmailError"></div>
                        </div>

                        <div class="form-group full-width">
                            <label for="adresse">Adresse complète</label>
                            <input type="text" name="adresse" id="adresse" placeholder="Ville, Quartier" required>
                            <div class="error" id="AdresseError"></div>
                        </div>

                        <div class="form-group full-width">
                            <label for="register-password">Mot de passe</label>
                            <input type="password" name="password" id="register-password" placeholder="Créez un mot de passe" required>
                            <div class="error" id="passwordError"></div>
                        </div>
                    
                        <div class="form-group full-width">
                            <label for="photo">Photo de profil</label>
                            <input type="file" name="photo" id="photo" accept="image/*" required>
                            <div class="error" id="TelError"></div>
                        </div>
                    </div>

                    <!-- Rôle fixé à patient pour l'inscription publique -->
                    <input type="hidden" name="role" value="patient">
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