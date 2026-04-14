<?php 
require_once 'config.php'; 
include(BACKEND_PATH_ERREUR);
$profil = null;
if (isset($_SESSION['profil'])) {
    $profil = $_SESSION['profil'];
} else {
    header('Location: login.php');
    exit;
}

require_once 'admin2/model/NotificationDB.php';
$notifdb = new NotificationDB();
$notifications = $notifdb->readUser($profil->iduser);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - Eco-Santé</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="assets/css/eco_sante.css">
    <style>
        .notif-section {
            padding: 2rem 0;
        }
        .notif-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--box-shadow);
            overflow: hidden;
            max-width: 800px;
            margin: 0 auto;
        }
        .notif-card-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1.25rem 1.5rem;
            border-bottom: 2px solid var(--gray-light);
        }
        .notif-card-header h3 {
            margin: 0;
            font-size: 1.15rem;
            color: var(--text-color);
        }
        .notif-card-header i {
            color: var(--primary-color);
            font-size: 1.2rem;
        }
        .notif-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--gray-light);
            transition: background 0.2s;
        }
        .notif-item:last-child {
            border-bottom: none;
        }
        .notif-item:hover {
            background-color: var(--light-gray);
        }
        .notif-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e8f4fd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            flex-shrink: 0;
            font-size: 1rem;
        }
        .notif-body {
            flex: 1;
        }
        .notif-body strong {
            display: block;
            font-size: 0.95rem;
            color: var(--text-color);
            margin-bottom: 2px;
        }
        .notif-body p {
            font-size: 0.87rem;
            color: var(--gray);
            margin: 0 0 4px 0;
        }
        .notif-body small {
            font-size: 0.78rem;
            color: var(--gray);
        }
        .notif-empty {
            text-align: center;
            padding: 3rem 1.5rem;
            color: var(--gray);
        }
        .notif-empty i {
            font-size: 3rem;
            display: block;
            margin-bottom: 1rem;
            color: var(--accent-color);
        }
        .notif-statut {
            display: inline-block;
            font-size: 0.72rem;
            padding: 2px 8px;
            border-radius: 20px;
            background-color: #e8f4fd;
            color: var(--primary-color);
            font-weight: 600;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="container">
            <?php include('includes/header.php') ?>
        </div>
    </header>

    <!-- Section Notifications -->
    <section class="notif-section">
        <div class="container">
            <div class="notif-card">
                <div class="notif-card-header">
                    <i class="fas fa-bell"></i>
                    <h3>Mes Notifications</h3>
                </div>

                <?php if ($notifications && count($notifications) > 0) : ?>
                    <?php foreach ($notifications as $notif) : ?>
                        <div class="notif-item">
                            <div class="notif-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="notif-body">
                                <strong><?= htmlspecialchars($notif->objet ?? 'Notification') ?></strong>
                                <p><?= htmlspecialchars($notif->description ?? '') ?></p>
                                <small>
                                    <i class="fas fa-clock" style="margin-right:4px;"></i>
                                    <?= isset($notif->created_at) ? date('d/m/Y à H:i', strtotime($notif->created_at)) : '' ?>
                                    &nbsp;•&nbsp;
                                    <span class="notif-statut"><?= htmlspecialchars($notif->statut ?? '') ?></span>
                                </small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="notif-empty">
                        <i class="fas fa-bell-slash"></i>
                        <p>Vous n'avez aucune notification pour le moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include('includes/footer.php') ?>

    <script src="assets/js/eco_sante.js"></script>
</body>

</html>