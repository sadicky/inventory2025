<?php

require_once('../../Models/Admin/branches.class.php');
$branches = new Branches();

$title = "Branches";

ob_start();
$data = $branches->getAll();


?>

<div class="col-md-12">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#"><?= $title ?></a></li>
        </ol>
    </nav>

    <div id="message"></div>
    <div class="ms-panel" style="margin: 10px 50px 10px 50px;">

        <div class="ms-panel-header">
            <h6>Branches</h6>
        </div>
        <div class="ms-panel-body">
            <form method="post" id="form_branche" class="needs-validation" novalidate>
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="branche">Branche</label>
                        <input type="text" required class="form-control" name="branche" id="branche" placeholder="Nouvelle Branche">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="adresse">Adresse</label>
                        <textarea placeholder="localisation" name="adresse" class="form-control" id="adresse"></textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <button class="btn btn-primary btn-sm" type="submit"> <span style="color: white;" class="fa fa-save"></span> Enregistrer</button>
                    </div>
                </div>
            </form>
            <hr>
            <div class="table-responsive">
                <table id="data-table" class="table table-condensed table-bordered table-sm display">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Branche</th>
                            <th>Localisation</th>
                            <th>Statut</th>
                            <th>Activer/Suspendre</th>
                            <!-- <th>Actions</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $b): ?>
                            <tr>
                                <td><?= $b->branche_id ?></td>
                                <td><?= $b->branche ?></td>
                                <td><?= $b->adresse ?></td>
                                <td>
                                    <?php if ($b->statut == 1): ?>
                                        <span class="badge badge-pill badge-primary">Actif</span>
                                    <?php else: ?>
                                        <span class="badge badge-pill badge-danger">Suspendu</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($b->statut == 1): ?>
                                        <a href="javascript:void(0)" id="<?= $b->branche_id ?>" class="text-center text-danger activer"><i class="fa fa-times-circle"></i>Suspendre?</a>
                                    <?php else: ?>
                                        <a href="javascript:void(0)" id="<?= $b->branche_id ?>" class="text-center text-sucess activer"><i class="fa fa-check-circle"></i>Activer?</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div style="padding-top: 20px;"></div>

</div>

<script src="assets/js/data-tables.js"></script>