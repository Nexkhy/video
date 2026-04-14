<?php 
// Gere les paiements avec l'api Nelsius
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
use Nelsius\NelsiusClient;

$action = $_GET['action'];

// Fonction pour garder une trace des transactions
function logPayment($message, $data = null) {
    $logFile = dirname(__DIR__) . '/logs/payment.log';
    $timestamp = date('Y-m-d H:i:s');
    $content = "[$timestamp] $message";
    if ($data) {
        $content .= " | Data: " . (is_array($data) ? json_encode($data) : $data);
    }
    file_put_contents($logFile, $content . PHP_EOL, FILE_APPEND);
}


// Lancement du processus de paiement
if ($action == 'pay_consultation') {
    try {
        $idconsultation = $_POST['idconsultation'] ?? null;
        $iduser         = $_POST['iduser'] ?? null;
        $idmedecin      = $_POST['idmedecin'] ?? null;
        $motif          = $_POST['motif'] ?? '';
        
        $montant = 0;
        $taux = 0;
        $reference = '';

        if($idconsultation) {
            $consultation = $consultationdb->read($idconsultation);
            $montant = $consultation->montant;
            $taux = $consultation->taux;
            $reference = $consultation->reference;
            
            if (!$idmedecin) $idmedecin = $consultation->idmedecin;
            if (!$iduser) $iduser = $consultation->iduser;
            if (empty($motif)) $motif = "Paiement consultation " . $consultation->reference;
            
        } else {
            // Informations du médecin pour nouvelle consultation
            $medecin = $userdb->read($idmedecin);
            $montant = $medecin->montant_consultation;
            $taux = $medecin->taux;
            $reference = 'eco-' . time() . '-' . rand(100, 999);
        }

        // Sauvegarder les données de la transaction en session pour la validation retour
        $_SESSION['pending_payment'] = [
            'idconsultation' => $idconsultation,
            'iduser' => $iduser,
            'idmedecin' => $idmedecin,
            'motif' => $motif,
            'reference' => $reference,
            'montant' => $montant,
            'taux' => $taux
        ];


        logPayment("Initialisation du paiement pour l'utilisateur $iduser vers le médecin $idmedecin. Référence: $reference");


        // Initialisation du client Nelsius 
        $client = new NelsiusClient(NELSIUS_API_KEY, [
            'verify_ssl' => false 
        ]);

        $return_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?view=paiement.control&action=payment_success&ref=" . $reference;
        $cancel_url = "http://" . $_SERVER['HTTP_HOST'] . dirname(dirname($_SERVER['PHP_SELF'])) . "/dashboard_patient.php?error=cancel";

        $session = $client->checkout->createSession([
            'amount' => $montant,
            'currency' => 'XAF',
            'reference' => $reference,
            'description' => 'Paiement ' . $motif,
            'return_url' => $return_url,
            'cancel_url' => $cancel_url,
            'customer' => [
                'email' => $_SESSION['profil']->email ?? 'patient@ecosante.com',
                'name'  => ($_SESSION['profil']->nom ?? '') . ' ' . ($_SESSION['profil']->prenom ?? '')
            ]
        ]);

        logPayment("Session Nelsius créée.", $session);

        if (isset($session['data']['checkout_url'])) {
            $_SESSION['pending_payment']['nelsius_id'] = $session['data']['session_id'];
            logPayment("Redirection vers: " . $session['data']['checkout_url']);
            header('Location: ' . $session['data']['checkout_url']);
            exit;
        } else {

            logPayment("ERREUR: Impossible de créer la session Nelsius.", $session);
            throw new Exception("Impossible de créer la session de paiement Nelsius.");
        }
    } catch(Exception $ex) {
        logPayment("EXCEPTION (pay_consultation): " . $ex->getMessage());

        $_SESSION['erreur'] = array(
            'type' => 'danger',
            'message' => "Erreur lors de l'initialisation du paiement : " . $ex->getMessage()
        );
        header('Location:../dashboard_patient.php');
    }
}

// Verification de la reussite du paiement
if ($action == 'payment_success') {
    try {
        $ref_retour = $_GET['ref'] ?? '';
        
        if (!isset($_SESSION['pending_payment']) || $_SESSION['pending_payment']['reference'] !== $ref_retour) {
            logPayment("ERREUR retour: Session de paiement introuvable ou référence mismatch. Ref retour: $ref_retour", $_SESSION['pending_payment'] ?? 'Aucune session');
            throw new Exception("Session de paiement introuvable ou invalide.");
        }

        $payment_data = $_SESSION['pending_payment'];
        logPayment("Retour de paiement détecté pour la référence: $ref_retour");

        $iduser = $payment_data['iduser'];
        $idmedecin = $payment_data['idmedecin'];
        $motif = $payment_data['motif'];
        $reference_consultation = $payment_data['reference'];
        $montant = $payment_data['montant'];
        $taux = $payment_data['taux'];

        
        //  Vérification réelle auprès de Nelsius
        
        $client = new NelsiusClient(NELSIUS_API_KEY, [
            'verify_ssl' => false 
        ]);

        //  vérifie le statut réel via l'API Nelsius
        $nelsius_id = $payment_data['nelsius_id'] ?? $_GET['id'] ?? null;
        if (!$nelsius_id) {
            throw new Exception("ID de transaction Nelsius manquant.");
        }

        $res = $client->charges->get($nelsius_id);
        $status = $res['data']['payment_status'] ?? 'pending';
        
        logPayment("Statut récupéré auprès de Nelsius pour $nelsius_id: $status", $res);

        if (!in_array($status, ['completed', 'succeeded', 'success'])) {
            logPayment("Paiement échoué ou en attente. Statut: $status");
            throw new Exception("Le paiement n'est pas encore confirmé (Statut actuel : $status). Veuillez réessayer ou contacter le support.");
        }


        $idconsultation_session = $payment_data['idconsultation'] ?? null;
        // Définir le lien vidéo Jitsi pour les deux cas
        $video_link = JITSI_SERVER . "ecosante-" . $reference_consultation;

        if($idconsultation_session) {
            // Mise à jour d'une consultation existante
            $consultationdb->updateStatut($idconsultation_session, 'Payée');
            $consultationdb->updateVideoLink($idconsultation_session, $video_link);
            $idconsultation = $idconsultation_session;
        } else {
            //  Prévention du double paiement (si l'utilisateur actualise la page)
            $deja_existe = $consultationdb->readByReference($reference_consultation);
            if ($deja_existe) {
                logPayment("Doublon détecté pour la référence $reference_consultation. Annulation du traitement répétitif.");
                unset($_SESSION['pending_payment']);
                header('Location:../dashboard_patient.php');
                exit;
            }
       

            //  Création d'une nouvelle consultation
            $statut_consultation = 'Payée';
            $date_consultation = date('Y-m-d H:i:s');
            
            $consultationdb->create($iduser, $idmedecin, $reference_consultation, '', '', '', $montant, $taux, $statut_consultation, $date_consultation, '', $video_link);

            $consult_creee = $consultationdb->readByReference($reference_consultation);
            if (!$consult_creee) {
                throw new Exception("Erreur lors de la création de la consultation en base de données.");
            }
            $idconsultation = $consult_creee->idconsultation;
        }


        //  Création du paiement lié
        $idmode = 1; 
        $paiementdb->create($idconsultation, $idmode, $reference_consultation, $motif);

        // La commission est calculée sur le montant total
        $part_admin = $montant * ($taux / 100);
        $part_medecin = $montant - $part_admin;

        // Ajouter au solde du médecin 
        $userdb->updateSolde($idmedecin, $part_medecin);

        // Ajouter au solde de l'administrateur 
        $admins = $userdb->readRole('admin');
        if($admins != null && count($admins) > 0) {
            $idadmin = $admins[0]->iduser;
            $userdb->updateSolde($idadmin, $part_admin);
        }

        logPayment("Traitement réussi. Consultation ID: $idconsultation creee et portefeuilles mis a jour.");

        // Vider la session temporaire
        unset($_SESSION['pending_payment']);

        $patient = $userdb->read($iduser);
        $medecin = $userdb->read($idmedecin);
        if ($patient && $medecin) {
            $expediteur = ['email' => 'contact@ecosante.cm', 'nom' => 'Équipe Eco-Santé'];
            
            // Email du patient
            $destinataires_patient = [['email' => $patient->email, 'nom' => "{$patient->prenom} {$patient->nom}"]];
            $objet_patient = "Confirmation de Paiement - Consultation prete";
            $message_html_patient = "
                <div style='font-family: Arial, sans-serif;'>
                    <h2 style='color: #27ae60;'>Paiement Confirme !</h2>
                    <p>Bonjour <strong>{$patient->prenom} {$patient->nom}</strong>,</p>
                    <p>Votre paiement de <strong>" . number_format($montant, 0, ',', ' ') . " FCFA</strong> a bien ete recu. Votre consultation avec le <strong>Dr. {$medecin->prenom} {$medecin->nom}</strong> est confirmee.</p>
                    <p><strong>Lien de la visioconference :</strong> <br><a href='{$video_link}'>{$video_link}</a></p>
                    <p>Merci de votre confiance.</p>
                </div>
            ";
            $mailer->sendMail($expediteur, $destinataires_patient, $objet_patient, $message_html_patient);

            // Email du docteur
            $destinataires_medecin = [['email' => $medecin->email, 'nom' => "Dr. {$medecin->nom} {$medecin->prenom}"]];
            $objet_medecin = "Paiement Effectue - Nouvelle consultation confirmee";
            $message_html_medecin = "
                <div style='font-family: Arial, sans-serif;'>
                    <h2 style='color: #27ae60;'>Nouveau Paiement Confirme !</h2>
                    <p>Bonjour Dr. <strong>{$medecin->prenom} {$medecin->nom}</strong>,</p>
                    <p>Le patient <strong>{$patient->prenom} {$patient->nom}</strong> vient de regler le montant de la consultation.</p>
                    <p>La teleconsultation est maintenant activee.</p>
                    <p><strong>Lien de la visioconference :</strong> <br><a href='{$video_link}'>{$video_link}</a></p>
                </div>
            ";
            $mailer->sendMail($expediteur, $destinataires_medecin, $objet_medecin, $message_html_medecin);

            // notification patient
            $notif_desc_patient = "Votre paiement de " . number_format($montant, 0, ',', ' ') . " FCFA a été validé. Consultation avec Dr. {$medecin->nom} active.";
            $notificationdb->create($iduser, "Consultation confirmée", $notif_desc_patient, "non lu");

            // notification docteur
            $notif_desc_medecin = "Le patient {$patient->prenom} {$patient->nom} a réglé sa consultation. Elle est maintenant disponible dans votre liste.";
            $notificationdb->create($idmedecin, "Nouveau paiement reçu", $notif_desc_medecin, "non lu");
        }

        $_SESSION['erreur'] = array(
            'type' => 'success',
            'message' => "Félicitations ! Votre paiement de " . number_format($montant, 0, ',', ' ') . " FCFA a été confirmé. Votre consultation est validée."
        );

        // Redirection directe vers la salle de consultation
        header('Location:../consult.php?id=' . $idconsultation);
        exit;
    } catch (Exception $ex) {
        logPayment("EXCEPTION (payment_success): " . $ex->getMessage());

        $_SESSION['erreur'] = array(
            'type' => 'danger',
            'message' => "Erreur de validation du paiement : " . $ex->getMessage()
        );
        header('Location:../dashboard_patient.php');
        exit;
    }
}
?>
