<?php 
// Gere les demandes de retrait d argent des medecins
$action = $_GET['action'];

// Le medecin demande a recuperer son argent
if ($action == 'demande_retrait') {
    try {
        $iduser = $_POST['iduser'];
        $montant = floatval($_POST['montant']);
        
        $user = $userdb->read($iduser);

        if ($montant > 0 && $user->solde >= $montant) {
            $userdb->updateSolde($iduser, -$montant);

            $date_demande = date('Y-m-d H:i:s');
            $retraitdb->create($iduser, $montant, $date_demande, 'En attente');

            $_SESSION['erreur'] = array(
                'type' => 'success',
                'message' => "Votre demande de retrait de $montant FCFA a été soumise et est en attente de validation."
            );
        } else {
            $_SESSION['erreur'] = array(
                'type' => 'danger',
                'message' => "Solde insuffisant pour ce retrait."
            );
        }

        header('Location:index.php?view=dashboard'); 
    } catch(Exception $ex) {
        $_SESSION['erreur'] = array(
            'type' => 'danger',
            'message' => "Erreur : " . $ex->getMessage()
        );
        header('Location:index.php?view=dashboard');
    }
}

// L administrateur valide le retrait
if ($action == 'valider_retrait') {
    try {
        $idretrait = $_REQUEST['idretrait'];
        $date_traitement = date('Y-m-d H:i:s');
        $retraitdb->updateStatut($idretrait, 'Validé', $date_traitement);

        $_SESSION['erreur'] = array(
            'type' => 'success',
            'message' => "La demande de retrait a été validée."
        );
        header('Location:index.php?view=retraits'); 
    } catch(Exception $ex) {
        $_SESSION['erreur'] = array(
            'type' => 'danger',
            'message' => "Erreur : " . $ex->getMessage()
        );
        header('Location:index.php?view=retraits');
    }
}

// Annulation du retrait et remboursement du medecin
if ($action == 'rejeter_retrait') {
    try {
        $idretrait = $_REQUEST['idretrait'];
        $retrait = $retraitdb->read($idretrait);

        if ($retrait->statut == 'En attente') {
            $userdb->updateSolde($retrait->iduser, $retrait->montant);

            $date_traitement = date('Y-m-d H:i:s');
            $retraitdb->updateStatut($idretrait, 'Rejeté', $date_traitement);

            $_SESSION['erreur'] = array(
                'type' => 'success',
                'message' => "La demande de retrait a été rejetée et le solde a été remboursé au médecin."
            );
        } else {
            $_SESSION['erreur'] = array(
                'type' => 'warning',
                'message' => "Ce retrait ne peut plus être rejeté."
            );
        }

        header('Location:index.php?view=retraits');
    } catch(Exception $ex) {
        $_SESSION['erreur'] = array(
            'type' => 'danger',
            'message' => "Erreur : " . $ex->getMessage()
        );
        header('Location:index.php?view=retraits');
    }
}
?>
