<?php
$action= 'index.php?view=user.control&action=create';
$user= null;
if(isset($_GET['id']) == true) {
    $action= 'index.php?view=user.control&action=update';
    $user= $userdb->read($_GET['id']);
}

$specialites= $specialitedb->readAll();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-sm-flex d-block">
                    <div class="mr-auto mb-sm-0 mb-3">
                        <h4 class="card-title mb-2">Ajouter un Utilisateur</h4>
                        <span>Gestion des utilisateurs</span>
                    </div>
                    <a href="index.php?view=user" class="btn btn-info">
                        <i class="flaticon-381-list-1"></i>
                        Liste des Utilisateurs
                    </a>
                </div>
                <div class="card-body">
                    <div class="form-validation">
                        <form class="form-valide" method="POST" enctype="multipart/form-data" action="<?= $action ?>">
                            <input 
                                type="hidden" 
                                class="form-control" 
                                id="iduser" 
                                name="iduser" 
                                value="<?= ($user != null)? $user->iduser : '' ?>">
                            

                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="idspecialite">
                                            Sélectionnez la spécialité
                                        </label>
                                        <div class="col-lg-6">
                                            <select class="form-control default-select" id="idspecialite" name="idspecialite">
                                                <?php if($user != null && $user->idspecialite != null && $user->idspecialite != ''): ?>
                                                <option value="<?php echo $user->idspecialite ?>" class="hide" selected>
                                                    <?php echo $user->specialite ?>
                                                </option>
                                                <?php endif ?>

                                                <option value="">
                                                    Aucune spécialité concernée
                                                </option>
                                                <?php 
                                                if($specialites != null && sizeof($specialites) > 0):
                                                    foreach ($specialites as $sp):
                                                ?>
                                                
                                                <option value="<?php echo $sp->idspecialite ?>">
                                                    <?php echo $sp->intitule ?>
                                                </option>

                                                <?php 
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="nom">
                                            Nom
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="nom" 
                                                name="nom" 
                                                placeholder="Entrez votre nom..." 
                                                required
                                                value="<?= ($user != null)? $user->nom : '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="prenom">
                                            Prénom
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="prenom" 
                                                name="prenom" 
                                                placeholder="Entrez votre prénom..." 
                                                required
                                                value="<?= ($user != null)? $user->prenom : '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="sexe">
                                            Sélectionnez le Sexe
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <div class="radio">
                                                <input type="radio" name="sexe" id="M" value="M" checked /> 
                                                <label for="M">Masculin</label>
                                            </div>
                                            <div class="radio">
                                                <input type="radio" name="sexe" id="F" value="F" />
                                                <label for="F">Féminin</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="adresse">
                                            Adresse 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <textarea 
                                                class="form-control" 
                                                id="adresse" 
                                                name="adresse" 
                                                rows="5" 
                                                placeholder="Donnez votre localisation" 
                                                required><?= ($user != null)? $user->adresse : '' ?></textarea>
                                        </div>
                                    </div>
                                </div>




                                <div class="col-xl-6">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="telephone">
                                            Téléphone
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <input 
                                                type="tel" 
                                                class="form-control" 
                                                id="telephone" 
                                                name="telephone" 
                                                placeholder="xxxxxxxxx" 
                                                required
                                                value="<?= ($user != null)? $user->telephone : '' ?>">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="email">
                                            Email
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <input 
                                                type="email" 
                                                class="form-control" 
                                                id="email" 
                                                name="email" 
                                                placeholder="Entrez votre email..." 
                                                required
                                                value="<?= ($user != null)? $user->email : '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="password">
                                            Mot de passe
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <input 
                                                type="password" 
                                                class="form-control" 
                                                id="password" 
                                                name="password" 
                                                placeholder="Entrez le mot de passe..." 
                                                required
                                                value="<?= ($user != null)? $user->password : '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="role">
                                            Sélectionnez le rôle
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <select class="form-control default-select" id="role" name="role">
                                                <?php if($user != null): ?>
                                                <option value="<?php echo $user->role ?>" class="hide" selected>
                                                    <?php echo $user->role ?>
                                                </option>
                                                <?php endif ?>

                                                <option value="patient">Patient</option>
                                                <option value="medecin" selected>Médecin</option>
                                                <option value="admin">Administrateur</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="photo">
                                            Sélectionnez une photo de profil
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <input 
                                                type="file" 
                                                class="form-control" 
                                                id="photo" 
                                                name="photo"
                                                accept=".jpg, .png, .jpeg, .gif">
                                            <div id="preview_image">
                                                <?php
                                                    if($user != null && $user->photo != null && $user->photo != '') {
                                                        echo '<img src="'. RES_USER_PHOTO['path'] . $user->photo .'" class="img-fluid mr-2" />';
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label"><a
                                                href="javascript:void()">Terms &amp; Conditions</a> <span
                                                class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <label class="css-control css-control-primary css-checkbox" for="val-terms">
                                                <input type="checkbox" class="css-control-input mr-2" id="val-terms" name="val-terms" value="1" checked>
                                                <span class="css-control-indicator"></span> 
                                                I agree to the terms
                                            </label>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <div class="col-lg-8 mr-auto">
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            <button type="reset" class="btn btn-light">Annuler</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
