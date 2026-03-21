<?php 
$action= $_GET['action'];



if($action == 'create') {
    try {
        $intitule= $_POST['intitule'];
        $montant_consultation= $_POST['montant_consultation'];
        $taux= $_POST['taux'];

        $data= $specialitedb->read($intitule);

        if($data != false) {
            $_SESSION['erreur']= array(
                'type' => 'warning',
                'message' => "La spécialité $intitule existe déjà"
            );
            header('Location:index.php?view=specialite.edit');
        }
        else {
            $specialitedb->create($intitule, $montant_consultation, $taux);
            $_SESSION['erreur']= array(
                'type' => 'success',
                'message' => "La spécialité $intitule a été ajoutée avec succès"
            );

            header('Location:index.php?view=specialite');
        }
    }
    catch(Exception $ex) {
        $_SESSION['erreur']= array(
            'type' => 'danger',
            'message' => "ERROR REQUEST : $ex->getMessage()"
        );
        header('Location:index.php?view=specialite.edit');
    }
}






if($action == 'update') {
    try {
        $idspecialite= $_POST['idspecialite'];
        $specialite= $specialitedb->read($idspecialite);

        $intitule= $_POST['intitule'];
        $montant_consultation= $_POST['montant_consultation'];
        $taux= $_POST['taux'];

        $data= $specialitedb->read($intitule);

        if($data != false && $data->idspecialite != $specialite->idspecialite) {
            $_SESSION['erreur']= array(
                'type' => 'warning',
                'message' => "La spécialité $intitule existe déjà"
            );
            header("Location:index.php?view=specialite.edit&id=$specialite->idspecialite");
        }
        else {
            $specialitedb->update($idspecialite, $intitule, $montant_consultation, $taux);
            $_SESSION['erreur']= array(
                'type' => 'success',
                'message' => "La spécialité $intitule a été modifiée avec succès"
            );

            header('Location:index.php?view=specialite');
        }
    }
    catch(Exception $ex) {
        $_SESSION['erreur']= array(
            'type' => 'danger',
            'message' => "ERROR REQUEST : $ex->getMessage()"
        );
        header("Location:index.php?view=specialite.edit&id=$specialite->idspecialite");
    }
}







if($action == 'delete') {
    try {
        $idspecialite= $_REQUEST['id'];
        $specialitedb->delete($idspecialite);

        $_SESSION['erreur']= array(
            'type' => 'success',
            'message' => "La spécialité $specialite->intitule a été supprimée avec succès"
        );
        header('Location:index.php?view=specialite');
    }
    catch(Exception $ex) {
        $_SESSION['erreur']= array(
            'type' => 'danger',
            'message' => "ERROR REQUEST : $ex->getMessage()"
        );
        header('Location:index.php?view=specialite.edit');
    }
}




?>