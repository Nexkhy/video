<?php 
require_once 'config.php'; 
require_once BACKEND_PATH_SERVICE;
include(BACKEND_PATH_ERREUR);

// Rediriger si déjà connecté
if (isset($_SESSION['profil'])) {
    $role = $_SESSION['profil']->role ?? 'patient';
    if ($role === 'medecin' || $role === 'admin') {
        header('Location: ' . BACKEND_PATH_INDEX);
    } else {
        header('Location: dashboard_patient.php');
    }
    exit;
}

$specialites = $specialitedb->readAll();
$msg = $_GET['msg'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Médecin - Eco-Santé</title>
    <link rel="stylesheet" href="./assets/fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/eco_sante.css">
    <style>
        .register-medecin-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #e8f4fd 0%, #f0faf4 100%);
            display: flex;
            flex-direction: column;
        }
        .register-medecin-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 0;
        }
        .register-medecin-header .header-content {
            height: 56px;
        }
        .form-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1rem;
        }
        .medecin-form-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.10);
            padding: 2.5rem 2rem;
            max-width: 620px;
            width: 100%;
        }
        .medecin-form-card h2 {
            color: var(--primary-color);
            font-size: 1.5rem;
            margin-bottom: 0.25rem;
        }
        .medecin-form-card p.subtitle {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 1.75rem;
            border-bottom: 1px solid var(--gray-light);
            padding-bottom: 1rem;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        .form-grid .full-width {
            grid-column: 1 / -1;
        }
        .form-group label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-color);
            display: block;
            margin-bottom: 4px;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid var(--gray-light);
            border-radius: 8px;
            font-size: 0.9rem;
            transition: border-color 0.2s;
            outline: none;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(45, 156, 219, 0.12);
        }
        .alert-success-msg {
            background: #d4edda;
            color: #155724;
            border-radius: 10px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .submit-btn {
            width: 100%;
            padding: 12px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 1rem;
            transition: background 0.2s;
        }
        .submit-btn:hover { background: #1b7cb0; }
        .info-box {
            background: #e8f4fd;
            border-left: 4px solid var(--primary-color);
            border-radius: 8px;
            padding: 0.85rem 1rem;
            margin-bottom: 1.25rem;
            font-size: 0.85rem;
            color: var(--gray-dark);
        }
        @media (max-width: 600px) {
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body class="register-medecin-page">

    <!-- Header simplifié -->
    <header class="register-medecin-header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="index.php"><i class="fas fa-heartbeat"></i></a>
                    <h1>Eco-Santé</h1>
                </div>
                <nav>
                    <a href="index.php" class="nav-link">Accueil</a>
                    &nbsp;&nbsp;
                    <a href="login.php" class="nav-link btn" style="padding:6px 14px; background:var(--primary-color); color:white; border-radius:20px;">Se connecter</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Formulaire -->
    <div class="form-section">
        <div class="medecin-form-card">
            <h2><i class="fas fa-user-md" style="margin-right:8px;"></i>Inscription Médecin / Soignant</h2>
            <p class="subtitle">Remplissez le formulaire. Votre demande sera examinée par notre équipe et vous recevrez vos identifiants par email.</p>

            <?php if ($msg === 'success') : ?>
            <div class="alert-success-msg">
                <i class="fas fa-check-circle fa-lg"></i>
                <div>
                    <strong>Demande envoyée !</strong><br>
                    Votre dossier est en cours d'examen. Vous recevrez un email avec vos accès dès validation.
                </div>
            </div>
            <?php endif; ?>

            <div class="info-box">
                <i class="fas fa-info-circle" style="margin-right:6px; color:var(--primary-color);"></i>
                Votre demande sera validée par un administrateur. Une fois approuvée, vos identifiants de connexion vous seront envoyés par email.
            </div>

            <form action="<?= BACKEND_PATH_INDEX ?>?view=user.control&action=preinscription_medecin" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nom *</label>
                        <input type="text" name="nom" placeholder="Votre nom" required>
                    </div>
                    <div class="form-group">
                        <label>Prénom *</label>
                        <input type="text" name="prenom" placeholder="Votre prénom" required>
                    </div>
                    <div class="form-group">
                        <label>Sexe *</label>
                        <select name="sexe" required>
                            <option value="">-- Sélectionner --</option>
                            <option value="M">Masculin</option>
                            <option value="F">Féminin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Téléphone *</label>
                        <input type="tel" name="telephone" placeholder="Ex: 699000000" required>
                    </div>
                    <div class="form-group full-width">
                        <label>Email professionnel *</label>
                        <input type="email" name="email" placeholder="votre@email.com" required>
                    </div>
                    <div class="form-group full-width">
                        <label>Adresse *</label>
                        <input type="text" name="adresse" placeholder="Ville, Quartier" required>
                    </div>
                    <div class="form-group full-width">
                        <label>Spécialité médicale *</label>
                        <select name="idspecialite" required>
                            <option value="">-- Sélectionnez votre spécialité --</option>
                            <?php 
                            if ($specialites) {
                                foreach ($specialites as $s) {
                                    echo '<option value="' . $s->idspecialite . '">' . htmlspecialchars($s->intitule) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group full-width">
                        <label>Photo de profil</label>
                        <input type="file" name="photo" accept="image/*">
                    </div>
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane" style="margin-right:6px;"></i>
                    Envoyer ma demande
                </button>
                <p style="text-align:center; margin-top:1rem; font-size:0.87rem; color:var(--gray);">
                    Déjà inscrit ? <a href="login.php" style="color:var(--primary-color);">Se connecter</a>
                    &nbsp;|&nbsp;
                    <a href="register.php" style="color:var(--gray);">Inscription patient</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
