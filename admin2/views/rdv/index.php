<?php
if($_SESSION['profil']->role == 'medecin') {
    $rdvs = $rdvdb->readMedecin($_SESSION['profil']->iduser);
} else {
    $rdvs = $rdvdb->readAll();
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Rendez-vous</h4>
            <span>Gestion des demandes de rendez-vous</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table style-1" id="ListDatatableView">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>PATIENT</th>
                            <th>MOTIF</th>
                            <th>DATE & DURÉE</th>
                            <th>STATUT</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if($rdvs != null && sizeof($rdvs) > 0): 
                                $i= 0;
                                foreach($rdvs as $rdv):
                                    $i++;
                                    $valider = "index.php?view=rdv.control&action=updateStatut&id=$rdv->idrdv&statut=validé";
                                    $annuler = "index.php?view=rdv.control&action=updateStatut&id=$rdv->idrdv&statut=annulé";
                                    $delete = "index.php?view=rdv.control&action=delete&id=$rdv->idrdv";
                        ?>
                        
                        <tr>
                            <td><h6><?= $i ?>.</h6></td>
                            <td>
                                <div class="media style-1">
                                    <img src="<?= RES_USER_PHOTO['path'] . ($rdv->photo_patient ?: 'user.png') ?>" class="img-fluid mr-2" alt="">
                                    <div class="media-body">
                                        <h6><?= $rdv->nom_patient ?> <?= $rdv->prenom_patient ?></h6>
                                        <span><?= $rdv->email_patient ?></span>
                                    </div>
                                </div>
                            </td>
                            <td><?= $rdv->motif ?></td>
                            <td>
                                <h6><?= date('d/m/Y H:i', strtotime($rdv->date_rdv)) ?></h6>
                                <small>Durée: <?= $rdv->duree ?></small>
                            </td>
                            <td>
                                <?php 
                                    $s = strtolower($rdv->statut);
                                    if($s == 'en attente') echo '<span class="badge badge-warning">En attente</span>';
                                    else if($s == 'validé') echo '<span class="badge badge-success">Validé</span>';
                                    else echo '<span class="badge badge-danger">'.ucfirst($rdv->statut).'</span>';
                                ?>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <?php if($s == 'en attente'): ?>
                                    <a href="<?= $valider ?>" class="btn btn-success btn-xs mr-2">Valider</a>
                                    <a href="<?= $annuler ?>" class="btn btn-warning btn-xs mr-2">Annuler</a>
                                    <?php endif; ?>
                                    <a href="<?= $delete ?>" class="btn btn-danger btn-xs" onclick="return confirm('Supprimer ?')">Supprimer</a>
                                </div>
                            </td>
                        </tr>

                        <?php 
                            endforeach;
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
