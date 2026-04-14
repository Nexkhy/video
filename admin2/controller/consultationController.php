<?php 
// Gere les consultations medicales en ligne
$action= $_GET['action'];

// Ouverture d'une nouvelle consultation
if($action == 'create') {
    try {
        $iduser= $_POST['iduser'];
        $idmedecin= $_POST['idmedecin'];
        $medecin= $userdb->read($idmedecin);

        $reference= 'eco-' . date('dmYHis') . rand(1, 1000);
        $poids= $_POST['poids'];
        $taille= $_POST['taille'];
        $tension= $_POST['tension'];
        $montant= $medecin->montant_consultation;
        $taux= $medecin->taux;
        $statut= 'Non payée';
        $date_consultation= date('Y-m-d H:i:s');
        $document= '';

        if(isset($_FILES['document']) == true && $_FILES['document']['size'] > 0) {
            $document= $upload->upload_file($_FILES['document'], RES_CONSULTATION_DOC['prefix_name'], RES_CONSULTATION_DOC['path']);
        }

        $video_link = "https://meet.jit.si/ecosante-" . $reference;
        $consultationdb->create($iduser, $idmedecin, $reference, $poids, $taille, $tension, $montant, $taux, $statut, $date_consultation, $document, $video_link);

        $_SESSION['erreur']= array(
            'type' => 'success',
            'message' => "La consultation $reference a été ajoutée avec succès"
        );

        header('Location:index.php?view=consultation');
    }
    catch(Exception $ex) {
        $_SESSION['erreur']= array(
            'type' => 'danger',
            'message' => "ERROR REQUEST : $ex->getMessage()"
        );
        header('Location:index.php?view=consultation.edit');
    }
}

// Mise a jour des informations pendant la consultation
if($action == 'update') {
    try {
        $idconsultation= $_POST['idconsultation'];
        $consultation= $consultationdb->read($idconsultation);

        $iduser= $_POST['iduser'];
        $idmedecin= $_POST['idmedecin'];
        $medecin= $userdb->read($_POST['idmedecin']);

        $reference= $consultation->reference;
        $poids= $_POST['poids'];
        $taille= $_POST['taille'];
        $tension= $_POST['tension'];
        $montant= $medecin->montant_consultation;
        $taux= $medecin->taux;
        $statut= $consultation->statut;
        $date_consultation= $consultation->date_consultation;

        $document= $consultation->document;

        if(isset($_FILES['document']) == true && $_FILES['document']['size'] > 0) {
            unlink(RES_CONSULTATION_DOC['path'] . $consultation->document);
            $document= $upload->upload_file($_FILES['document'], RES_CONSULTATION_DOC['prefix_name'], RES_CONSULTATION_DOC['path']);
        }

        $video_link= $consultation->video_link;
        $consultationdb->update($idconsultation, $iduser, $idmedecin, $reference, $poids, $taille, $tension, $montant, $taux, $statut, $date_consultation, $document, $video_link);

        $_SESSION['erreur']= array(
            'type' => 'success',
            'message' => "La consultation $reference a été modifiée avec succès"
        );

        header('Location:index.php?view=consultation');
    }
    catch(Exception $ex) {
        $_SESSION['erreur']= array(
            'type' => 'danger',
            'message' => "ERROR REQUEST : $ex->getMessage()"
        );
        header("Location:index.php?view=consultation.edit&id=$consultation->idconsultation");
    }
}

// Changer le statut de la consultation
if($action == 'update_statut') {
    try {
        $idconsultation= $_REQUEST['idconsultation'];
        $statut= $_REQUEST['statut'];

        $consultationdb->updateStatut($idconsultation, $statut);
        $_SESSION['erreur']= array(
            'type' => 'success',
            'message' => "Le statut de la consultation a été modifiée avec succès"
        );

        header('Location:index.php?view=consultation');
    }
    catch(Exception $ex) {
        $_SESSION['erreur']= array(
            'type' => 'danger',
            'message' => "ERROR REQUEST : $ex->getMessage()"
        );
        header("Location:index.php?view=consultation.edit&id=$idconsultation");
    }
}

// Suppression d'une consultation
if($action == 'delete') {
    try {
        $idconsultation= $_REQUEST['id'];
        $consultation= $consultationdb->read($idconsultation);

        unlink(RES_CONSULTATION_DOC['path'] . $consultation->document);
        $consultationdb->delete($idconsultation);

        $_SESSION['erreur']= array(
            'type' => 'success',
            'message' => "La consultation $consultation->reference a été supprimée avec succès"
        );

        header('Location:index.php?view=consultation');
    }
    catch(Exception $ex) {
        $_SESSION['erreur']= array(
            'type' => 'danger',
            'message' => "ERROR REQUEST : $ex->getMessage()"
        );
        header('Location:index.php?view=consultation.edit');
    }
}

// Envoyer un mail au patient quand le docteur est pret
if ($action == 'notify_patient') {
    try {
        $idconsultation = $_GET['id'];
        $consultation = $consultationdb->read($idconsultation);
        
        if ($consultation) {
            $patient = $userdb->read($consultation->iduser);
            $medecin = $userdb->read($consultation->idmedecin);
            
            if ($patient && $medecin) {
                $expediteur = ['email' => 'contact@ecosante.cm', 'nom' => 'Équipe Eco-Santé'];
                $destinataires = [['email' => $patient->email, 'nom' => "{$patient->nom} {$patient->prenom}"]];
                $objet = "Votre médecin vous attend en consultation - Eco-Santé";
                
                $message_html = "
                    <div style='font-family: Arial, sans-serif;'>
                        <h2 style='color: #2980b9;'>Le Docteur est en ligne !</h2>
                        <p>Bonjour <strong>{$patient->prenom} {$patient->nom}</strong>,</p>
                        <p>Le <strong>Dr. {$medecin->prenom} {$medecin->nom}</strong> vient de rejoindre la salle de téléconsultation et vous attend.</p>
                        <p>Veuillez rejoindre la visioconférence dès que possible en cliquant sur le lien ci-dessous :</p>
                        <p><a href='{$consultation->video_link}' style='background: #e74c3c; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;'>Rejoindre la consultation</a></p>
                    </div>
                ";
                
                $mailer->sendMail($expediteur, $destinataires, $objet, $message_html);
                
                $_SESSION['erreur'] = array(
                    'type' => 'success',
                    'message' => "Le patient a été notifié par email avec succès."
                );
            }
        }
        header("Location: ../consult.php?id=$idconsultation");
    } catch (Exception $ex) {
        $_SESSION['erreur'] = array(
            'type' => 'danger',
            'message' => "Erreur lors de la notification : " . $ex->getMessage()
        );
        header("Location: ../consult.php?id=$idconsultation");
    }
}
?>