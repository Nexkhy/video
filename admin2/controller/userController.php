<?php 
$action= $_GET['action'];



if($action == 'create') {
    try {
        $idspecialite= null;
        if(isset($_POST['idspecialite']) == true && 
            $_POST['idspecialite'] != null &&
            $_POST['idspecialite'] != "") {
            $idspecialite= $_POST['idspecialite'];
        }
        $nom= $_POST['nom'];
        $prenom= $_POST['prenom'];
        $sexe= $_POST['sexe'];
        $adresse= $_POST['adresse'];
        $telephone= $_POST['telephone'];
        $email= $_POST['email'];
        $password= $_POST['password'];
        $password_h= password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role= $_POST['role'];
        $photo= '';
        $statut= 'offline';

        $data= $userdb->readConnexion2($email, $password);

        if($data != false) {
            $_SESSION['erreur']= array(
                'type' => 'warning',
                'message' => "Email et/ou mot de passe déjà existant"
            );
            header('Location:index.php?view=user.edit');
        }
        else {
            if(isset($_FILES['photo']) == true && $_FILES['photo']['size'] > 0) {
                $photo= $upload->upload_image($_FILES['photo'], RES_USER_PHOTO['prefix_name'], RES_USER_PHOTO['width_max'], RES_USER_PHOTO['height_max'], RES_USER_PHOTO['path']);
            }

            // On crée l'utilisateur avec le mot de passe hashé : $password_h
            $userdb->create($idspecialite, $nom, $prenom, $sexe, $adresse, $telephone, $email, $password_h, $role, $photo, $statut);
            $_SESSION['erreur']= array(
                'type' => 'success',
                'message' => "L'utilisateur $nom a été ajoutée avec succès"
            );

            header('Location:index.php?view=user');
        }
    }
    catch(Exception $ex) {
        $_SESSION['erreur']= array(
            'type' => 'danger',
            'message' => "ERROR REQUEST : $ex->getMessage()"
        );
        header('Location:index.php?view=user.edit');
    }
}






if($action == 'update') {
    try {
        $iduser= $_POST['iduser'];
        $user= $userdb->read($iduser);

        $idspecialite= $user->idspecialite;
        if(isset($_POST['idspecialite']) == true) {
            if($_POST['idspecialite'] == null || $_POST['idspecialite'] == "" ) {
                $idspecialite= null;
            }
            else {
                $idspecialite= $_POST['idspecialite'];
            }  
        }

        $nom= $_POST['nom'];
        $prenom= $_POST['prenom'];
        $sexe= $_POST['sexe'];
        $adresse= $_POST['adresse'];
        $telephone= $_POST['telephone'];
        $email= $_POST['email'];
        $password= $_POST['password'];
        $password_h= password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role= $_POST['role'];
        $photo= $user->photo;
        $statut= $user->statut;

        $data= $userdb->readConnexion2($email, $password);

        if($data != false && $data->iduser != $user->iduser) {
            $_SESSION['erreur']= array(
                'type' => 'warning',
                'message' => "Email et/ou mot de passe déjà existant"
            );
            header("Location:index.php?view=user.edit&id=$user->iduser");
        }
        else {
            if(isset($_FILES['photo']) == true && $_FILES['photo']['size'] > 0) {
                unlink(RES_USER_PHOTO['path'] . $user->photo);
                $photo= $upload->upload_image($_FILES['photo'], RES_USER_PHOTO['prefix_name'], RES_USER_PHOTO['width_max'], RES_USER_PHOTO['height_max'], RES_USER_PHOTO['path']);
            }

            $userdb->update($iduser, $idspecialite, $nom, $prenom, $sexe, $adresse, $telephone, $email, $password_h, $role, $photo, $statut);
            $_SESSION['erreur']= array(
                'type' => 'success',
                'message' => "L'utilisateur $user->nom a été modifiée avec succès"
            );

            header('Location:index.php?view=user');
        }
    }
    catch(Exception $ex) {
        $_SESSION['erreur']= array(
            'type' => 'danger',
            'message' => "ERROR REQUEST : $ex->getMessage()"
        );
        header("Location:index.php?view=user.edit&id=$user->iduser");
    }
}







if($action == 'delete') {
    try {
        $iduser= $_REQUEST['id'];
        $user= $userdb->read($iduser);

        unlink(RES_USER_PHOTO['path'] . $user->photo);
        $userdb->delete($iduser);

        $_SESSION['erreur']= array(
            'type' => 'success',
            'message' => "L'utilisateur $user->nom a été supprimée avec succès"
        );

        header('Location:index.php?view=user');
    }
    catch(Exception $ex) {
        $_SESSION['erreur']= array(
            'type' => 'danger',
            'message' => "ERROR REQUEST : $ex->getMessage()"
        );
        header('Location:index.php?view=user.edit');
    }
}




?>