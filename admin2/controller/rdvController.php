<?php
// Gere les rendez vous entre les patients et les medecins
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // Demander un nouveau rendez vous
    if ($action == 'create') {
        extract($_POST);
        
        $statut = 'en attente';
        $rdvdb->create($iduser, $idmedecin, $motif, $date_rdv, $duree, $statut);
        
        $medecin = $userdb->read($idmedecin);
        $patient = $userdb->read($iduser);
        
        if ($medecin && $patient) {
            $expediteur = ['email' => 'contact@ecosante.cm', 'nom' => 'Équipe Eco-Santé'];
            $destinataires = [['email' => $medecin->email, 'nom' => "Dr. {$medecin->nom} {$medecin->prenom}"]];
            $objet = "Nouvelle demande de rendez-vous - Eco-Santé";
            $message_html = "
                <div style='font-family: Arial, sans-serif;'>
                    <h2 style='color: #27ae60;'>Nouveau Rendez-vous !</h2>
                    <p>Bonjour Dr. <strong>{$medecin->prenom} {$medecin->nom}</strong>,</p>
                    <p>Le patient <strong>{$patient->prenom} {$patient->nom}</strong> vient de demander un rendez-vous.</p>
                    <ul>
                        <li><strong>Motif :</strong> {$motif}</li>
                        <li><strong>Date et Heure :</strong> " . date('d/m/Y à H:i', strtotime($date_rdv)) . "</li>
                        <li><strong>Durée :</strong> {$duree}</li>
                    </ul>
                    <p>Connectez-vous à votre espace professionnel pour le valider.</p>
                </div>
            ";
            $mailer->sendMail($expediteur, $destinataires, $objet, $message_html);
        }

        header("Location: ../profil_medecin.php?id=$idmedecin&msg=success");
        exit;
    }

    // Valider ou refuser un rendez vous
    if ($action == 'updateStatut') {
        $id = $_GET['id'];
        $statut = $_GET['statut'];
        
        $rdv = $rdvdb->read($id);
        
        if ($rdv) {
            $rdvdb->updateStatut($id, $statut);
            
            if ($statut == 'validé') {
                $reference = "CONS-" . time() . "-" . $rdv->iduser;
                $poids = null; $taille = null; $tension = null;
                
                $medecin = $userdb->read($rdv->idmedecin);
                $patient = $userdb->read($rdv->iduser);
                $montant = $medecin->montant_consultation ?? 0;
                $taux = $medecin->taux ?? 0;
                
                $consultationdb->create(
                    $rdv->iduser, 
                    $rdv->idmedecin, 
                    $reference, 
                    $poids, 
                    $taille, 
                    $tension, 
                    $montant, 
                    $taux, 
                    'Non payée', 
                    $rdv->date_rdv, 
                    null
                );
                
                if ($medecin && $patient) {
                    $expediteur = ['email' => 'contact@ecosante.cm', 'nom' => 'Équipe Eco-Santé'];
                    $destinataires = [['email' => $patient->email, 'nom' => "{$patient->nom} {$patient->prenom}"]];
                    $objet = "Rendez-vous validé - Paiement requis";
                    $message_html = "
                        <div style='font-family: Arial, sans-serif;'>
                            <h2 style='color: #27ae60;'>Votre rendez-vous a été validé !</h2>
                            <p>Bonjour <strong>{$patient->prenom} {$patient->nom}</strong>,</p>
                            <p>Le <strong>Dr. {$medecin->prenom} {$medecin->nom}</strong> a validé votre rendez-vous prévu le <strong>" . date('d/m/Y à H:i', strtotime($rdv->date_rdv)) . "</strong>.</p>
                            <p>Pour confirmer définitivement cette consultation, veuillez procéder au paiement de <strong>" . number_format($montant, 0, ',', ' ') . " FCFA</strong>.</p>
                            <p><a href='http://{$_SERVER['HTTP_HOST']}/consult.php' style='background: #e74c3c; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;'>Procéder au paiement</a></p>
                        </div>
                    ";
                    $mailer->sendMail($expediteur, $destinataires, $objet, $message_html);
                }
            }
        }
        
        header('Location: index.php?view=rdv');
    }

    // Supprimer un rendez vous existant
    if ($action == 'delete') {
        $id = $_GET['id'];
        $rdvdb->delete($id);
        header('Location: index.php?view=rdv');
    }
}
?>
