<?php
require_once 'config.php';
require_once 'vendor/autoload.php';
require_once BACKEND_PATH_SERVICE;

use Nelsius\NelsiusClient;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idmedecin = $_POST['idmedecin'];
    $idpatient = $_POST['idpatient'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $montant = $_POST['montant'];

    $medecin = $userdb->read($idmedecin);
    $patient = $_SESSION['profil'];

    $client = new NelsiusClient(NELSIUS_API_KEY, [
        'base_url' => NELSIUS_BASE_URL,
        'verify_ssl' => false
    ]);

    try {
        $reference = 'CONSULT_' . time() . '_' . $idmedecin . '_' . $idpatient;
        
        // Store temporary data in session or database to retrieve after payment
        // Better store in session for now, or create a pending consultation
        $_SESSION['pending_consultation'] = [
            'idmedecin' => $idmedecin,
            'idpatient' => $idpatient,
            'date' => $date,
            'heure' => $heure,
            'montant' => $montant,
            'reference' => $reference
        ];

        $session = $client->checkout->createSession([
            'amount' => $montant,
            'currency' => 'XAF',
            'reference' => $reference,
            'description' => 'Consultation avec Dr. ' . $medecin->nom . ' ' . $medecin->prenom,
            'return_url' => 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/success_paiement.php?reference=' . $reference,
            'cancel_url' => 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/cancel_paiement.php',
            'customer' => [
                'email' => $patient->email,
                'name' => $patient->nom . ' ' . $patient->prenom
            ]
        ]);

        if (isset($session['data']['checkout_url'])) {
            header('Location: ' . $session['data']['checkout_url']);
            exit();
        } else {
            throw new Exception("Impossible de générer le lien de paiement.");
        }

    } catch (Exception $e) {
        $_SESSION['erreur'] = [
            'type' => 'danger',
            'message' => "Erreur de paiement : " . $e->getMessage()
        ];
        header('Location: medecin.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
