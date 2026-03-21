<?php 
$action= $_GET['action'];



if($action == 'create') {
    try {
        $intitule= $_POST['intitule'];

        $data= $modedb->read($intitule);

        if($data != false) {
            $_SESSION['erreur']= array(
                'type' => 'warning',
                'message' => "Le mode de paiement $intitule existe déjà"
            );
            header('Location:index.php?view=mode.edit');
        }
        else {
            $modedb->create($intitule);
            $_SESSION['erreur']= array(
                'type' => 'success',
                'message' => "Le mode de paiement $intitule a été ajoutée avec succès"
            );

            header('Location:index.php?view=mode');
        }
    }
    catch(Exception $ex) {
        $_SESSION['erreur']= array(
            'type' => 'danger',
            'message' => "ERROR REQUEST : $ex->getMessage()"
        );
        header('Location:index.php?view=mode.edit');
    }
}






if($action == 'update') {
    try {
        $idmode= $_POST['idmode'];
        $mode= $modedb->read($idmode);

        $intitule= $_POST['intitule'];

        $data= $modedb->read($intitule);

        if($data != false && $data->idmode != $mode->idmode) {
            $_SESSION['erreur']= array(
                'type' => 'warning',
                'message' => "Le mode de paiement $intitule existe déjà"
            );
            header("Location:index.php?view=mode.edit&id=$mode->idmode");
        }
        else {
            $modedb->update($idmode, $intitule);
            $_SESSION['erreur']= array(
                'type' => 'success',
                'message' => "Le mode de paiement $intitule a été modifiée avec succès"
            );

            header('Location:index.php?view=mode');
        }
    }
    catch(Exception $ex) {
        $_SESSION['erreur']= array(
            'type' => 'danger',
            'message' => "ERROR REQUEST : $ex->getMessage()"
        );
        header("Location:index.php?view=mode.edit&id=$mode->idmode");
    }
}







if($action == 'delete') {
    try {
        $idmode= $_REQUEST['id'];
        $modedb->delete($idmode);

        $_SESSION['erreur']= array(
            'type' => 'success',
            'message' => "Le mode de paiement $mode->intitule a été supprimée avec succès"
        );
        header('Location:index.php?view=mode');
    }
    catch(Exception $ex) {
        $_SESSION['erreur']= array(
            'type' => 'danger',
            'message' => "ERROR REQUEST : $ex->getMessage()"
        );
        header('Location:index.php?view=mode.edit');
    }
}




?>