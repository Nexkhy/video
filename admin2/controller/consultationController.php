<?php 
$action= $_GET['action'];



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

        $consultationdb->create($iduser, $idmedecin, $reference, $poids, $taille, $tension, $montant, $taux, $statut, $date_consultation, $document);
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
        $statut= 'Non Payé';
        $date_consultation= $consultation->date_consultation;
        $document= $consultation->document;


        if(isset($_FILES['document']) == true && $_FILES['document']['size'] > 0) {
            unlink(RES_CONSULTATION_DOC['path'] . $consultation->document);
            $document= $upload->upload_file($_FILES['document'], RES_CONSULTATION_DOC['prefix_name'], RES_CONSULTATION_DOC['path']);
        }

        $consultationdb->update($idconsultation, $iduser, $idmedecin, $reference, $poids, $taille, $tension, $montant, $taux, $statut, $date_consultation, $document);
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









if($action == 'update_statut') {
    try {
        $idconsultation= $_REQUEST['idconsultation'];
        $statut= $_REQUEST['statut'];

        $consultationdb->updateStatut($idconsultation, $statut);
        $_SESSION['erreur']= array(
            'type' => 'success',
            'message' => "Le statut de la consultation $reference a été modifiée avec succès"
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




?>