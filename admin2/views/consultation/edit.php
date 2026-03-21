<?php
$action= 'index.php?view=consultation.control&action=create';
$consultation= null;
if(isset($_GET['id']) == true) {
    $action= 'index.php?view=consultation.control&action=update';
    $consultation= $consultationdb->read($_GET['id']);
}

$patients= $userdb->readRole('patient');
$medecins= $userdb->readRole('medecin');
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-sm-flex d-block">
                    <div class="mr-auto mb-sm-0 mb-3">
                        <h4 class="card-title mb-2">Ajouter une Consultation</h4>
                        <span>Gestion des consultations</span>
                    </div>
                    <a href="index.php?view=consultation" class="btn btn-info">
                        <i class="flaticon-381-list-1"></i>
                        Liste des Consultations
                    </a>
                </div>
                <div class="card-body">
                    <div class="form-validation">
                        <form class="form-valide" method="POST" enctype="multipart/form-data" action="<?= $action ?>">
                            <input 
                                type="hidden" 
                                class="form-control" 
                                id="idconsultation" 
                                name="idconsultation" 
                                value="<?= ($consultation != null)? $consultation->idconsultation : '' ?>">
                            

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="form-group row">
                                        <label class="col-lg-5 col-form-label" for="idspecialite">
                                            Sélectionnez un Patient
                                        </label>
                                        <div class="col-lg-7">
                                            <select class="form-control default-select" id="iduser" name="iduser">
                                                <?php if($consultation != null): ?>
                                                <option value="<?php echo $consultation->iduser ?>" class="hide" selected>
                                                    <?php echo $consultation->nom_patient ?>
                                                    <?php echo $consultation->prenom_patient ?>
                                                </option>
                                                <?php endif ?>

                                                <?php 
                                                if($patients != null && sizeof($patients) > 0):
                                                    foreach ($patients as $patient):
                                                ?>
                                                
                                                <option value="<?php echo $patient->iduser ?>">
                                                    <?php echo $patient->nom ?> 
                                                    <?php echo $patient->prenom ?>
                                                </option>

                                                <?php 
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-5 col-form-label" for="idmedecin">
                                            Sélectionnez un Médecin
                                        </label>
                                        <div class="col-lg-7">
                                            <select class="form-control default-select" id="idmedecin" name="idmedecin">
                                                <?php if($consultation != null): ?>
                                                <option value="<?php echo $consultation->idmedecin ?>" class="hide" selected>
                                                    <?php echo $consultation->nom_medecin ?>
                                                    <?php echo $consultation->prenom_medecin ?>
                                                </option>
                                                <?php endif ?>

                                                <?php 
                                                if($medecins != null && sizeof($medecins) > 0):
                                                    foreach ($medecins as $medecin):
                                                ?>
                                                
                                                <option value="<?php echo $medecin->iduser ?>">
                                                    <?php echo $medecin->nom ?> 
                                                    <?php echo $medecin->prenom ?>
                                                </option>

                                                <?php 
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-5 col-form-label" for="poids">
                                            Poids
                                        </label>
                                        <div class="col-lg-7">
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="poids" 
                                                name="poids" 
                                                placeholder="Entrez le poids..." 
                                                value="<?= ($consultation != null)? $consultation->poids : '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-5 col-form-label" for="taille">
                                            Taille
                                        </label>
                                        <div class="col-lg-7">
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="taille" 
                                                name="taille" 
                                                placeholder="Entrez la taille..." 
                                                value="<?= ($consultation != null)? $consultation->taille : '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-5 col-form-label" for="tension">
                                            Tension
                                        </label>
                                        <div class="col-lg-7">
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="tension" 
                                                name="tension" 
                                                placeholder="Entrez la tension..." 
                                                value="<?= ($consultation != null)? $consultation->tension : '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-5 col-form-label" for="document">
                                            Sélectionnez un document
                                        </label>
                                        <div class="col-lg-7">
                                            <input 
                                                type="file" 
                                                class="form-control" 
                                                id="document" 
                                                name="document"
                                                accept=".pdf, .docx, .doc">
                                            <div id="preview_file" class="text-center">
                                                <?php
                                                    if($consultation != null && $consultation->document != null && $consultation->document != '') {
                                                        echo '<a target="_blank" href="'.RES_CONSULTATION_DOC['path']. $consultation->document . '">';
                                                        echo '<i class="flaticon-381-download"></i>';
                                                        echo '</a>';
                                                    }
                                                ?>
                                            </div>
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
