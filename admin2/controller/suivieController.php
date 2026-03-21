<?php 
$action= $_GET['action'];



if($action == 'create') {
    try {
        $idconsultation= $_POST['idconsultation'];
        $observation= $_POST['observation'];
        $recommendations= $_POST['recommendations'];
        $nature_rdv= $_POST['nature_rdv'];
        $date_suivie= date('Y-m-d H:i:s');
        $date_prochain_rdv= $_POST['date_prochain_rdv'];
        $document= '';

        if(isset($_FILES['document']) == true && $_FILES['document']['size'] > 0) {
            $document= $upload->upload_file($_FILES['document'], RES_SUIVIE_DOC['prefix_name'], RES_SUIVIE_DOC['path']);
        }

        $suiviedb->create($idconsultation, $observation, $recommandations, $nature_rdv, $date_suivie, $date_prochain_rdv, $document);
        $_SESSION['erreur']= array(
            'type' => 'success',
            'message' => "Le suivie a été ajoutée avec succès"
        );

        header("Location:index.php?view=suivie");
    }
    catch(Exception $ex) {
        $_SESSION['erreur']= array(
            'type' => 'danger',
            'message' => "ERROR REQUEST : $ex->getMessage()"
        );
        header("Location:index.php?view=suivie.edit");
    }
}






if($action == 'update') {
    try {
        $idsuivie= $_POST['idsuivie'];
        $suivie= $suiviedb->read($idsuivie);

        $idconsultation= $_POST['idconsultation'];
        $observation= $_POST['observation'];
        $recommendations= $_POST['recommendations'];
        $nature_rdv= $_POST['nature_rdv'];
        $date_suivie= $suivie->date_suivie;
        $date_prochain_rdv= $_POST['date_prochain_rdv'];
        $document= $suivie->document;

        if(isset($_FILES['document']) == true && $_FILES['document']['size'] > 0) {
            unlink(RES_SUIVIE_DOC['path'] . $suivie->document);
            $document= $upload->upload_file($_FILES['document'], RES_SUIVIE_DOC['prefix_name'], RES_SUIVIE_DOC['path']);
        }

        $suiviedb->update($idsuivie, $idconsultation, $observation, $recommandations, $nature_rdv, $date_suivie, $date_prochain_rdv, $document);
        $_SESSION['erreur']= array(
            'type' => 'success',
            'message' => "Le suivie a été modifiée avec succès"
        );

        header("Location:index.php?view=suivie");
    }
    catch(Exception $ex) {
        $_SESSION['erreur']= array(
            'type' => 'danger',
            'message' => "ERROR REQUEST : $ex->getMessage()"
        );
        header("Location:index.php?view=suivie.edit&id=$suivie->idsuivie");
    }
}









if($action == 'delete') {
    try {
        $idsuivie= $_REQUEST['id'];
        $suivie= $suiviedb->read($idsuivie);

        unlink(RES_SUIVIE_DOC['path'] . $suivie->document);
        $suiviedb->delete($idsuivie);

        $_SESSION['erreur']= array(
            'type' => 'success',
            'message' => "Le suivie a été supprimée avec succès"
        );

        header("Location:index.php?view=suivie");
    }
    catch(Exception $ex) {
        $_SESSION['erreur']= array(
            'type' => 'danger',
            'message' => "ERROR REQUEST : $ex->getMessage()"
        );
        header("Location:index.php?view=suivie.edit");
    }
}




?>