<?php
$action= 'index.php?view=mode.control&action=create';
$mode= null;
if(isset($_GET['id']) == true) {
    $action= 'index.php?view=mode.control&action=update';
    $mode= $modedb->read($_GET['id']);
}

$modes= $modedb->readAll();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-sm-flex d-block">
                    <div class="mr-auto mb-sm-0 mb-3">
                        <h4 class="card-title mb-2">Ajouter un Mode de paiement</h4>
                        <span>Gestion des Modes de paiements</span>
                    </div>
                    <a href="index.php?view=mode" class="btn btn-info">
                        <i class="flaticon-381-list-1"></i>
                        Liste des Modes de paiements
                    </a>
                </div>
                <div class="card-body">
                    <div class="form-validation">
                        <form class="form-valide" method="POST" enctype="multipart/form-data" action="<?= $action ?>">
                            <input 
                                type="hidden" 
                                class="form-control" 
                                id="idmode" 
                                name="idmode" 
                                value="<?= ($mode != null)? $mode->idmode : '' ?>">
                            

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="intitule">
                                            Intitulé
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="intitule" 
                                                name="intitule" 
                                                placeholder="Entrez la Mode de paiement" 
                                                required
                                                value="<?= ($mode != null)? $mode->intitule : '' ?>">
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
