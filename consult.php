<?php 
require_once 'config.php'; 
require_once 'admin2/model/ConsultationDB.php';
include(BACKEND_PATH_ERREUR);

$consultationdb = new ConsultationDB();
$profil = null;
if(isset($_SESSION['profil'])) {
    $profil = $_SESSION['profil'];
} else {
    header('Location: login.php');
    exit();
}

$id_consult_room = $_GET['id'] ?? null;
$current_consultation = null;

if($id_consult_room) {
    $current_consultation = $consultationdb->read($id_consult_room);
    // Vérification de sécurité : le patient ne peut voir que sa propre consultation et si elle est payée
    if(!$current_consultation || $current_consultation->iduser != $profil->iduser || (strtolower($current_consultation->statut) != 'payée' && strtolower($current_consultation->statut) != 'payé')) {
        $current_consultation = null;
    }
}


$consultations = $consultationdb->readPatient($profil->iduser);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Consultations | Eco-Santé</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/eco_sante.css">
    <style>
        .consultation-list { margin-top: 20px; }
        .consultation-card { 
            background: white; border-radius: 10px; padding: 15px; margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;
        }
        .consultation-info h4 { margin: 0 0 5px 0; color: #2c3e50; }
        .consultation-info p { margin: 2px 0; color: #7f8c8d; font-size: 0.9em; }
        .status-badge { padding: 4px 8px; border-radius: 4px; font-size: 0.8em; font-weight: bold; }
        .status-paid { background: #e8f5e9; color: #2e7d32; }
        .status-pending { background: #fff3e0; color: #ef6c00; }
        .video-room { margin-top: 30px; background: #000; border-radius: 15px; overflow: hidden; aspect-ratio: 16/9; }
        .no-data { text-align: center; padding: 40px; color: #95a5a6; }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <?php include('includes/header.php') ?>
        </div>
    </header>

    <section class="page">
        <div class="container">
            <?php if($current_consultation): ?>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2><i class="fas fa-video mr-2"></i> Téléconsultation avec Dr. <?= $current_consultation->nom_medecin ?></h2>
                    <a href="consult.php" class="btn-primary" style="background: #e74c3c; text-decoration: none; padding: 8px 15px; border-radius: 5px;">Quitter</a>
                </div>
                
                <div class="video-room mb-3">
                    <?php 
                    // On extrait le nom de la salle du lien Jitsi (on enlève l'URL de base)
                    $room_name = str_replace(JITSI_SERVER, "", $current_consultation->video_link);
                    // On ajoute le nom d'affichage du patient pour Jitsi
                    $display_name = $profil->nom . " " . $profil->prenom;
                    ?>
                    <iframe src="<?= JITSI_SERVER . $room_name ?>#config.startWithAudioMuted=true&config.startWithVideoMuted=true&userInfo.displayName=<?= urlencode($display_name) ?>" 
                            allow="camera; microphone; fullscreen; display-capture; autoplay" 
                            style="width: 100%; height: 100%; border: none;"></iframe>
                </div>
                
                <div class="alert alert-info small d-flex align-items-center justify-content-between">
                    <div>
                        <i class="fas fa-info-circle mr-2"></i> 
                        <strong>Problème d'affichage ?</strong> Si la vidéo ne s'affiche pas, ouvrez la salle dans un nouvel onglet.
                    </div>
                    <a href="<?= $current_consultation->video_link ?>#userInfo.displayName=<?= urlencode($display_name) ?>" target="_blank" class="btn btn-info btn-sm ml-3">
                        Ouvrir dans un nouvel onglet
                    </a>
                </div>
                
                <?php if($_SESSION['profil']->role == 'medecin'): ?>
                    <div class="alert alert-warning small mt-2">
                        <i class="fas fa-user-shield mr-2"></i>
                        <strong>Action requise (Médecin) :</strong> Si Jitsi demande un modérateur, cliquez sur "Je suis l'hôte" et connectez-vous (Google/GitHub). Cela n'est nécessaire qu'une seule fois par session.
                    </div>
                    <div class="mt-3">
                        <a href="admin2/index.php?view=consultation.control&action=notify_patient&id=<?= $current_consultation->idconsultation ?>" class="btn-primary" style="background: #2980b9; text-decoration: none; padding: 10px 20px; border-radius: 5px; display: inline-block;">
                            <i class="fas fa-bell mr-1"></i> Notifier le patient que je suis en ligne
                        </a>
                    </div>
                <?php endif; ?>


            <?php else: ?>
                <h2><i class="fas fa-stethoscope mr-2"></i> Mes Rendez-vous</h2>
                
                <div class="consultation-list">
                    <?php if($consultations && count($consultations) > 0): ?>
                        <?php foreach($consultations as $c): ?>
                            <div class="consultation-card">
                                <div class="consultation-info">
                                    <h4>Dr. <?= $c->nom_medecin ?> <?= $c->prenom_medecin ?></h4>
                                    <p><i class="far fa-calendar-alt mr-1"></i> Date : <?= date('d/m/Y à H:i', strtotime($c->date_consultation)) ?></p>
                                    <p><i class="fas fa-tag mr-1"></i> Réf : <?= $c->reference ?></p>
                                    <span class="status-badge <?= (strtolower($c->statut) == 'payée' || strtolower($c->statut) == 'payé') ? 'status-paid' : 'status-pending' ?>">
                                        <?= (strtolower($c->statut) == 'payée' || strtolower($c->statut) == 'payé') ? 'Payée' : 'En attente' ?>
                                    </span>
                                </div>
                                <div class="consultation-actions">
                                    <?php if((strtolower($c->statut) == 'payée' || strtolower($c->statut) == 'payé') && $c->video_link): ?>
                                        <a href="consult.php?id=<?= $c->idconsultation ?>" class="btn-primary" style="text-decoration: none; padding: 10px 20px; border-radius: 5px; display: inline-block;">
                                            <i class="fas fa-video mr-1"></i> Rejoindre
                                        </a>
                                    <?php elseif(strtolower($c->statut) == 'non payée' || strtolower($c->statut) == 'non payé'): ?>
                                        <form action="admin2/index.php?view=paiement.control&action=pay_consultation" method="POST">
                                            <input type="hidden" name="idconsultation" value="<?= $c->idconsultation ?>">
                                            <input type="hidden" name="iduser" value="<?= $profil->iduser ?>">
                                            <input type="hidden" name="idmedecin" value="<?= $c->idmedecin ?>">
                                            <input type="hidden" name="motif" value="Consultation #<?= $c->reference ?>">
                                            <button type="submit" class="btn-primary" style="background: #27ae60; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
                                                <i class="fas fa-credit-card mr-1"></i> Payer (<?= number_format($c->montant, 0, ',', ' ') ?> FCFA)
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn-primary" disabled style="background: #bdc3c7; cursor: not-allowed;">Indisponible</button>
                                    <?php endif; ?>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-data">
                            <i class="fas fa-calendar-times fa-3x mb-3"></i>
                            <p>Vous n'avez pas encore de rendez-vous programmé.</p>
                            <a href="index.php" class="btn-primary" style="margin-top: 15px; display: inline-block; text-decoration: none;">Prendre rendez-vous</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include('includes/footer.php') ?>
</body>
</html>