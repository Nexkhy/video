<?php
$action= 'index.php?view=specialite.control&action=create';
$specialite= null;
if(isset($_GET['id']) == true) {
    $action= 'index.php?view=specialite.control&action=update';
    $specialite= $specialitedb->read($_GET['id']);
}

$specialites= $specialitedb->readAll();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-sm-flex d-block">
                    <div class="mr-auto mb-sm-0 mb-3">
                        <h4 class="card-title mb-2">Ajouter une Spécialité</h4>
                        <span>Gestion des spécialités</span>
                    </div>
                    <a href="index.php?view=specialite" class="btn btn-info">
                        <i class="flaticon-381-list-1"></i>
                        Liste des Spécialités
                    </a>
                </div>
                <div class="card-body">
                    <div class="form-validation">
                        <form class="form-valide" method="POST" enctype="multipart/form-data" action="<?= $action ?>">
                            <input 
                                type="hidden" 
                                class="form-control" 
                                id="idspecialite" 
                                name="idspecialite" 
                                value="<?= ($specialite != null)? $specialite->idspecialite : '' ?>">
                            

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="nom">
                                            Intitulé
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="intitule" 
                                                name="intitule" 
                                                placeholder="Entrez la spécialité" 
                                                required
                                                value="<?= ($specialite != null)? $specialite->intitule : '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="prenom">
                                            Montant de la consultation
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <input 
                                                type="number" 
                                                class="form-control" 
                                                id="montant_consultation" 
                                                name="montant_consultation" 
                                                required
                                                value="<?= ($specialite != null)? $specialite->montant_consultation : '4000' ?>">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="prenom">
                                            Taux de commision (%)
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <input 
                                                type="number" 
                                                class="form-control" 
                                                id="taux" 
                                                name="taux" 
                                                required
                                                value="<?= ($specialite != null)? $specialite->taux : '10' ?>">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <div class="col-lg-8 mr-auto text-right">
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
