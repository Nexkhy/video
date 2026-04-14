<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>Gestion des Retraits</h4>
                <span><?= ($profil->role == 'medecin') ? 'Consultez l\'historique de vos demandes de retrait' : 'Validez ou rejetez les demandes de retrait des médecins' ?></span>

            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Retraits</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Toutes les demandes</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Date Demande</th>
                                    <th>Médecin</th>
                                    <th>Montant (FCFA)</th>
                                    <th>Statut</th>
                                    <th>Date Traitement</th>
                                    <?php if($profil->role == 'admin'): ?>
                                    <th>Action</th>
                                    <?php endif; ?>
                                </tr>

                            </thead>
                            <tbody>
                                <?php 
                                    if($profil->role == 'medecin') {
                                        $retraits = $retraitdb->readUser($profil->iduser);
                                    } else {
                                        $retraits = $retraitdb->readAll();
                                    }
                                    foreach($retraits as $r): 
                                ?>

                                <tr>
                                    <td><?= date('d/m/Y H:i', strtotime($r->date_demande)) ?></td>
                                    <td><strong><?= $r->nom . ' ' . $r->prenom ?></strong></td>
                                    <td><?= number_format($r->montant, 0, ',', ' ') ?></td>
                                    <td>
                                        <?php if($r->statut == 'En attente'): ?>
                                            <span class="badge badge-warning text-white">En attente</span>
                                        <?php elseif($r->statut == 'Validé'): ?>
                                            <span class="badge badge-success">Validé</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Rejeté</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $r->date_traitement ? date('d/m/Y H:i', strtotime($r->date_traitement)) : '-' ?></td>
                                    <?php if($profil->role == 'admin'): ?>
                                    <td>
                                        <?php if($r->statut == 'En attente'): ?>
                                            <div class="d-flex">
                                                <a href="index.php?view=retrait.control&action=valider_retrait&idretrait=<?= $r->idretrait ?>" class="btn btn-success shadow btn-xs sharp mr-1" title="Valider"><i class="fa fa-check"></i></a>
                                                <a href="index.php?view=retrait.control&action=rejeter_retrait&idretrait=<?= $r->idretrait ?>" class="btn btn-danger shadow btn-xs sharp" title="Rejeter"><i class="fa fa-times"></i></a>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted">Traité</span>
                                        <?php endif; ?>
                                    </td>
                                    <?php endif; ?>

                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
