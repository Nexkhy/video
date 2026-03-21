<?php
$consultations= $consultationdb->readAll();
?>


<div class="container-fluid">
    <div class="card">
        <div class="card-header d-sm-flex d-block">
            <div class="mr-auto mb-sm-0 mb-3">
                <h4 class="card-title mb-2">Consultations</h4>
                <span>Gestion des consultations</span>
            </div>
            <a class="btn btn-info" href="index.php?view=consultation.edit">
                + Ajouter un Consultation
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table style-1" id="ListDatatableView">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>PATIENT</th>
                            <th>MEDECIN</th>
                            <th>FICHE MEDICAL</th>
                            <th>MONTANT</th>
                            <th>DATE</th>
                            <th>STATUT</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if($consultations != null && sizeof($consultations) > 0): 
                                $i= 0;
                                foreach($consultations as $consultation):
                                    $i++;
                                    $update= "index.php?view=consultation.edit&id=$consultation->idconsultation";
                                    $delete= "index.php?view=consultation.control&action=delete&id=$consultation->idconsultation";
                        ?>
                        
                        <tr>
                            <td>
                                <h6><?= $i ?>.</h6>
                            </td>
                            <td>
                                <div class="media style-1">
                                    <?php 
                                        if($consultation->photo_patient != null && $consultation->photo_patient != '') {
                                            echo '<img src="'. RES_USER_PHOTO['path'] . $consultation->photo_patient .'" class="img-fluid mr-2" alt="">';
                                        }
                                        else {
                                            echo '<img src="'. RES_USER_PHOTO['path'] .'user.png" class="img-fluid mr-2" alt="">';
                                        }
                                    ?>
                                    
                                    <div class="media-body">
                                        <h6>
                                            <?= $consultation->nom_patient ?>
                                        </h6>
                                        <span>
                                            <?= $consultation->email_patient ?>
                                            <br />
                                            Sexe : <?= $consultation->sexe_patient ?>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="media style-1">
                                    <?php 
                                        if($consultation->photo_medecin != null && $consultation->photo_medecin != '') {
                                            echo '<img src="'. RES_USER_PHOTO['path'] . $consultation->photo_medecin .'" class="img-fluid mr-2" alt="">';
                                        }
                                        else {
                                            echo '<img src="'. RES_USER_PHOTO['path'] .'user.png" class="img-fluid mr-2" alt="">';
                                        }
                                    ?>
                                    
                                    <div class="media-body">
                                        <h6>
                                            <?= $consultation->nom_medecin ?>
                                        </h6>
                                        <span>
                                            <?= $consultation->email_medecin ?>
                                            <br />
                                            Sexe : <?= $consultation->sexe_medecin ?>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <h6>
                                        Paramètres
                                    </h6>
                                    <span>
                                        Poids (Kg) : <?= $consultation->poids ?>
                                        <br />
                                        Taille (Cm) : <?= $consultation->taille ?>
                                        <br />
                                        Tension : <?= $consultation->tension ?>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <h6 class="text-primary">
                                        <?= $consultation->montant ?>
                                    </h6>
                                    <span>
                                        Taux de commision (%) : <?= $consultation->taux ?>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <h6>
                                        <?= $consultation->date_consultation ?>
                                    </h6>
                                    <span></span>
                                </div>
                            </td>
                            <td>
                                <?php 
                                    if($consultation->statut == 'Non payée') {
                                        echo '<span class="badge badge-danger">'. $consultation->statut .'</span>';
                                        // echo '
                                        //     <a class="btn btn-info" href="index.php?view=consultation.control?action=update_statut&id='. $consultation->idconsultation .'&statut=Non payée">
                                        //         Valider
                                        //     </a>
                                        // ';
                                    }
                                    else if($consultation->statut == 'Payée') {
                                        echo '<span class="badge badge-success">'. $consultation->statut .'</span>';
                                    }
                                ?>
                            </td>
                            <td>
                                <div class="d-flex action-button">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    	<span class="flaticon-381-settings-5"></span>
									    	<span class="caret"></span>
									    </button>

                                        <ul class="dropdown-menu text-center">
                                            <li class="btn btn-success btn-xs" onclick="document.location.href='#'">
									    		<span>Effectuer le Paiement</span>
									    	</li>
                                            <li class="btn btn-info btn-xs" onclick="document.location.href='#'">
									    		<span>Effectuer un Suivi</span>
									    	</li>
                                        </ul>
                                    </div>

                                    &nbsp;

                                    <a href="<?= $update ?>" class="btn btn-info btn-xs light px-2">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M17 3C17.2626 2.73735 17.5744 2.52901 17.9176 2.38687C18.2608 2.24473 18.6286 2.17157 19 2.17157C19.3714 2.17157 19.7392 2.24473 20.0824 2.38687C20.4256 2.52901 20.7374 2.73735 21 3C21.2626 3.26264 21.471 3.57444 21.6131 3.9176C21.7553 4.26077 21.8284 4.62856 21.8284 5C21.8284 5.37143 21.7553 5.73923 21.6131 6.08239C21.471 6.42555 21.2626 6.73735 21 7L7.5 20.5L2 22L3.5 16.5L17 3Z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
                                    <a href="<?= $delete ?>" class="ml-2 btn btn-xs px-2 light btn-danger">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 6H5H21" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
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
