<?php 
// Gere les utilisateurs comme les medecins et patients
$action= $_GET['action'];

// Inscription d'un nouvel utilisateur
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
        $planning= isset($_POST['planning']) ? $_POST['planning'] : null;
        $creneaux= isset($_POST['creneaux']) ? $_POST['creneaux'] : null;

        $data= $userdb->readConnexion2($email, $password);

        if($data != false) {
            $_SESSION['erreur']= array(
                'type' => 'warning',
                'message' => "Email et/ou mot de passe déjà existant"
            );
            if (isset($_SESSION['profil'])) {
                header('Location:index.php?view=user.edit');
            } else {
                header('Location:../register.php');
            }
        }
        else {
            if(isset($_FILES['photo']) == true && $_FILES['photo']['size'] > 0) {
                $photo= $upload->upload_image($_FILES['photo'], RES_USER_PHOTO['prefix_name'], RES_USER_PHOTO['width_max'], RES_USER_PHOTO['height_max'], RES_USER_PHOTO['path']);
            }

            // On crée l'utilisateur avec le mot de passe hashé : $password_h
            $montant_consultation = $_POST['montant_consultation'] ?? null;
            $taux = $_POST['taux'] ?? null;

            $userdb->create($idspecialite, $nom, $prenom, $sexe, $adresse, $telephone, $email, $password_h, $role, $photo, $statut, $planning, $creneaux, $montant_consultation, $taux);
            $_SESSION['erreur']= array(
                'type' => 'success',
                'message' => "L'utilisateur $nom a été ajoutée avec succès"
            );

            if (isset($_SESSION['profil'])) {
                header('Location:index.php?view=user');
            } else {
                header('Location:../login.php');
            }
        }
    }
    catch(Exception $ex) {
        $_SESSION['erreur']= array(
            'type' => 'danger',
            'message' => "ERROR REQUEST : $ex->getMessage()"
        );
        if (isset($_SESSION['profil'])) {
            header('Location:index.php?view=user.edit');
        } else {
            header('Location:../register.php');
        }
    }
}






// Mise a jour des informations du profil
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
        if (empty($password)) {
            $password_h = $user->password;
        } else {
            $password_h = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }
        $role= $_POST['role'];
        $photo= $user->photo;
        $statut= $user->statut;
        $planning= isset($_POST['planning']) ? $_POST['planning'] : $user->planning;
        $creneaux= isset($_POST['creneaux']) ? $_POST['creneaux'] : $user->creneaux;

        $data= $userdb->readConnexion2($email, $password);

        if($data != false && $data->iduser != $user->iduser) {
            $_SESSION['erreur']= array(
                'type' => 'warning',
                'message' => "Email et/ou mot de passe déjà existant"
            );
            if (isset($_POST['from_profil'])) {
                header('Location:../profil.php');
            } else {
                header("Location:index.php?view=user.edit&id=$user->iduser");
            }
        }
        else {
            if(isset($_FILES['photo']) == true && $_FILES['photo']['size'] > 0) {
                unlink(RES_USER_PHOTO['path'] . $user->photo);
                $photo= $upload->upload_image($_FILES['photo'], RES_USER_PHOTO['prefix_name'], RES_USER_PHOTO['width_max'], RES_USER_PHOTO['height_max'], RES_USER_PHOTO['path']);
            }

            $montant_consultation = $_POST['montant_consultation'] ?? null;
            $taux = $_POST['taux'] ?? null;

            $userdb->update($iduser, $idspecialite, $nom, $prenom, $sexe, $adresse, $telephone, $email, $password_h, $role, $photo, $statut, $planning, $creneaux, $montant_consultation, $taux);
            
            if (isset($_SESSION['profil']) && $_SESSION['profil']->iduser == $iduser) {
                $_SESSION['profil'] = $userdb->read($iduser);
            }

            $_SESSION['erreur']= array(
                'type' => 'success',
                'message' => "L'utilisateur $nom a été modifiée avec succès"
            );

            if (isset($_POST['from_profil'])) {
                header('Location:../profil.php');
            } else {
                header('Location:index.php?view=user');
            }
        }
    }
    catch(Exception $ex) {
        $_SESSION['erreur']= array(
            'type' => 'danger',
            'message' => "ERROR REQUEST : $ex->getMessage()"
        );
        if (isset($_POST['from_profil'])) {
            header('Location:../profil.php');
        } else {
            header("Location:index.php?view=user.edit&id=$user->iduser");
        }
    }
}







// Suppression d'un compte utilisateur
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



// Demande d'inscription pour un nouveau medecin
if ($action == 'preinscription_medecin') {
    try {
        $idspecialite = isset($_POST['idspecialite']) && $_POST['idspecialite'] != '' ? $_POST['idspecialite'] : null;
        $nom       = $_POST['nom'];
        $prenom    = $_POST['prenom'];
        $sexe      = $_POST['sexe'];
        $adresse   = $_POST['adresse'];
        $telephone = $_POST['telephone'];
        $email     = $_POST['email'];
        $photo     = '';

        $existing = $userdb->readByEmail($email);
        if ($existing) {
            $_SESSION['erreur'] = ['type' => 'warning', 'message' => 'Un compte avec cet email existe déjà.'];
            header('Location: ../register_medecin.php');
            exit;
        }

        if (isset($_FILES['photo']) && $_FILES['photo']['size'] > 0) {
            $photo = $upload->upload_image($_FILES['photo'], RES_USER_PHOTO['prefix_name'], RES_USER_PHOTO['width_max'], RES_USER_PHOTO['height_max'], RES_USER_PHOTO['path']);
        }

        $password_h = password_hash(bin2hex(random_bytes(8)), PASSWORD_DEFAULT);
        $userdb->create($idspecialite, $nom, $prenom, $sexe, $adresse, $telephone, $email, $password_h, 'medecin', $photo, 'pending');

        header('Location: ../register_medecin.php?msg=success');
    } catch (Exception $ex) {
        $_SESSION['erreur'] = ['type' => 'danger', 'message' => 'Erreur : ' . $ex->getMessage()];
        header('Location: ../register_medecin.php');
    }
    exit;
}



// Validation du medecin par l'administrateur
if ($action == 'valider_medecin') {
    try {
        $iduser = $_GET['id'];
        $user   = $userdb->read($iduser);

        if (!$user || $user->role !== 'medecin') {
            throw new Exception('Médecin introuvable.');
        }

        $password_clair = ucfirst(substr($user->prenom, 0, 3)) . rand(1000, 9999) . '!';
        $password_h     = password_hash($password_clair, PASSWORD_DEFAULT);

        $userdb->update(
            $iduser, $user->idspecialite, $user->nom, $user->prenom,
            $user->sexe, $user->adresse, $user->telephone, $user->email,
            $password_h, 'medecin', $user->photo, 'offline',
            $user->planning ?? null, $user->creneaux ?? null,
            $user->montant_consultation ?? null, $user->taux ?? null
        );

        $expediteur = ['email' => 'contact@ecosante.cm', 'nom' => 'Équipe Eco-Santé'];
        $destinataires = [
            ['email' => $user->email, 'nom' => "Dr. {$user->nom} {$user->prenom}"]
        ];
        $objet = "Bienvenue sur Eco-Santé — Vos identifiants";
        
        $message_html = "
            <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6;'>
                <h2 style='color: #27ae60;'>Bienvenue sur Eco-Santé !</h2>
                <p>Bonjour Dr. <strong>{$user->nom} {$user->prenom}</strong>,</p>
                <p>Votre inscription a été validée avec succès par notre équipe d'administration.</p>
                <div style='background: #f8f9fa; padding: 15px; border-left: 4px solid #27ae60; margin: 20px 0;'>
                    <p style='margin: 0;'><strong>Vos identifiants de connexion :</strong></p>
                    <ul style='margin-top: 10px;'>
                        <li><strong>Email :</strong> {$user->email}</li>
                        <li><strong>Mot de passe :</strong> <span style='background:#e2e3e5; padding:2px 6px; border-radius:3px;'>{$password_clair}</span></li>
                    </ul>
                </div>
                <p>Vous pouvez vous connecter à votre espace médecin en cliquant sur le lien ci-dessous :</p>
                <p><a href='http://{$_SERVER['HTTP_HOST']}/admin2/' style='background: #27ae60; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;'>Accéder à mon espace</a></p>
                <p><i>Nous vous recommandons fortement de modifier ce mot de passe temporaire dès votre première connexion.</i></p>
                <hr style='border: none; border-top: 1px solid #eee; margin: 20px 0;'>
                <p style='font-size: 0.9em; color: #777;'>Cordialement,<br>L'équipe technique Eco-Santé</p>
            </div>
        ";
        
        $mailer->sendMail($expediteur, $destinataires, $objet, $message_html);

        $_SESSION['erreur'] = ['type' => 'success', 'message' => "Dr. {$user->nom} validé(e). Email envoyé à {$user->email}."];
        header('Location: index.php?view=user');
    } catch (Exception $ex) {
        $_SESSION['erreur'] = ['type' => 'danger', 'message' => 'Erreur : ' . $ex->getMessage()];
        header('Location: index.php?view=user');
    }
    exit;
}



?>