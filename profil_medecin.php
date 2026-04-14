<?php
require_once 'config.php';
require_once BACKEND_PATH_SERVICE;

$profil = null;
if (isset($_SESSION['profil']) == true) {
    $profil = $_SESSION['profil'];
} else {
    header('Location:login.php');
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location:medecin.php');
}

$idmedecin = $_GET['id'];
$medecin = $userdb->read($idmedecin);

if (!$medecin || $medecin->role != 'medecin') {
    header('Location:medecin.php');
}

$plannings = $planningdb->readUser($idmedecin);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Dr. <?= $medecin->nom ?> - Éco-Santé</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="assets/css/eco_sante.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        .profile-header {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .profile-img-large {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary-color);
        }

        .planning-card {
            background: #f8f9fa;
            border-left: 5px solid var(--primary-color);
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .price-badge {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <?php include('includes/header.php') ?>
        </div>
    </header>
    
    <section class="page mt-4">
        <div class="container">
            <div class="profile-header">
                <img src="admin2/ressources/user/<?= $medecin->photo ?: 'user.png' ?>" alt="Dr. <?= $medecin->nom ?>" class="profile-img-large">
                <div class="profile-info-main">
                    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'success'): ?>
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle me-2"></i> Votre demande de rendez-vous a été envoyée avec succès au médecin.
                        </div>
                    <?php endif; ?>
                    <h1 class="mb-1">Dr. <?= $medecin->prenom ?> <?= $medecin->nom ?></h1>
                    <h4 class="text-danger mb-3"><?= $medecin->specialite ?></h4>
                    <p class="text-muted"><i class="fas fa-envelope me-2"></i> <?= $medecin->email ?></p>
                    <p class="text-muted"><i class="fas fa-phone me-2"></i> <?= $medecin->telephone ?></p>
                    <div class="price-badge mt-2">
                        <?= number_format($medecin->montant_consultation ?: 0, 0, ',', ' ') ?> FCFA
                        <small class="text-muted" style="font-size: 0.8rem;">/ consultation</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h3 class="card-title mb-4"><i class="fas fa-calendar-alt me-2 text-primary"></i> Disponibilités</h3>
                            <?php if ($plannings && count($plannings) > 0): ?>
                                <div class="row">
                                    <?php foreach ($plannings as $plan): ?>
                                        <div class="col-md-6">
                                            <div class="planning-card">
                                                <h5 class="mb-1"><?= ucfirst($plan->jour) ?></h5>
                                                <p class="mb-0 text-primary fw-bold">
                                                    <?= date('H:i', strtotime($plan->heure_debut)) ?> - <?= date('H:i', strtotime($plan->heure_fin)) ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">Aucune disponibilité définie pour le moment.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title mb-4"><i class="fas fa-info-circle me-2 text-primary"></i> À propos</h3>
                            <p>Le Dr. <?= $medecin->nom ?> est un expert en <?= $medecin->specialite ?> dévoué à offrir les meilleurs soins possibles via téléconsultation.</p>
                            <ul>
                                <li>Consultations vidéo hautement sécurisées</li>
                                <li>Ordonnances numériques envoyées après chaque séance</li>
                                <li>Suivi personnalisé de votre dossier médical</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm sticky-top" style="top: 100px;">
                        <div class="card-body">
                            <h4 class="mb-4">Prendre RDV</h4>
                            <form action="admin2/index.php?view=rdv.control&action=create" method="POST" onsubmit="updateDateTime()">
                                <input type="hidden" name="iduser" value="<?= $profil->iduser ?>">
                                <input type="hidden" name="idmedecin" value="<?= $medecin->iduser ?>">
                                
                                <div class="mb-3">
                                    <label class="form-label">Motif</label>
                                    <input type="text" name="motif" class="form-control" placeholder="Ex: Maux de tête..." required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date souhaitée</label>
                                    <input type="date" name="date_day" class="form-control" required min="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Heure souhaitée</label>
                                    <input type="time" name="date_time" class="form-control" required>
                                </div>
                                <input type="hidden" name="date_rdv" id="final_date_rdv">
                                <input type="hidden" name="duree" value="00:30">

                                <button type="submit" class="btn btn-primary w-100">
                                    Confirmer la demande
                                </button>
                                <p class="mt-3 text-muted small"><i class="fas fa-info-circle"></i> Votre demande sera validée par le médecin.</p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include('includes/footer.php') ?>

    <script>
        function updateDateTime() {
            const day = document.querySelector('input[name="date_day"]').value;
            const time = document.querySelector('input[name="date_time"]').value;
            if (day && time) {
                document.getElementById('final_date_rdv').value = day + ' ' + time;
            }
        }
    </script>
</body>
</html>
