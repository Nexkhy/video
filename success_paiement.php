<?php
require_once 'config.php';
require_once 'vendor/autoload.php';
require_once BACKEND_PATH_SERVICE;

use Nelsius\NelsiusClient;

$reference = $_GET['reference'] ?? null;

if (!$reference) {
    header('Location: index.php');
    exit();
}

$client = new NelsiusClient(NELSIUS_API_KEY, [
    'base_url' => NELSIUS_BASE_URL,
    'verify_ssl' => false
]);

try {
    // 1. Éviter les doublons
    $existing = $consultationdb->readByReference($reference);
    if ($existing) {
        header('Location: dashboard_patient.php');
        exit();
    }

    // 2. Vérifier le statut via l'API
    // Note: On suppose que l'API supporte le filtrage par référence sur /charges
    $response = $client->request('GET', '/charges', ['reference' => $reference]);
    
    // On vérifie si on a un résultat et s'il est réussi
    $transaction = null;
    if (isset($response['data']) && is_array($response['data'])) {
        foreach($response['data'] as $t) {
            if ($t['reference'] === $reference && $t['status'] === 'success') {
                $transaction = $t;
                break;
            }
        }
    }

    if ($transaction) {
        $pending = $_SESSION['pending_consultation'] ?? null;

        if ($pending && $pending['reference'] === $reference) {
            $idmedecin = $pending['idmedecin'];
            $idpatient = $pending['idpatient'];
            $montant = $pending['montant'];
            $date_consultation = $pending['date'] . ' ' . $pending['heure'];
            
            $medecin = $userdb->read($idmedecin);
            $taux = $medecin->taux ?? 0;
            $commission_admin = ($montant * $taux) / 100;
            $net_medecin = $montant - $commission_admin;

            $video_link = "https://meet.jit.si/ecosante-" . $reference;

            // Enregistrer la consultation
            $consultationdb->create(
                $idpatient,
                $idmedecin,
                $reference,
                0, 0, 0, // Valeurs par défaut pour poids/taille/tension
                $montant,
                $taux,
                'payé',
                $date_consultation,
                '',
                $video_link
            );


            // Mettre à jour le solde du médecin
            $userdb->updateSolde($idmedecin, $net_medecin);

            unset($_SESSION['pending_consultation']);
            
            $_SESSION['message'] = "Paiement réussi ! Votre rendez-vous est confirmé.";
            header('Location: dashboard_patient.php');
            exit();
        }
    }
    
    throw new Exception("La transaction n'a pas pu être validée.");

} catch (Exception $e) {
    $_SESSION['erreur'] = "Erreur : " . $e->getMessage();
    header('Location: index.php');
    exit();
}
